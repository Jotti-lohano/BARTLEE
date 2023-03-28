<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Faqs\FaqsController;
use App\Http\Controllers\Admin\Pages\PageController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Admin\Boost\BoostController;
use App\Http\Controllers\Admin\Offers\OfferController;

use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\Events\EventsController;
use App\Http\Controllers\Admin\Report\ReportController;
use App\Http\Controllers\Admin\Auth\PassResetController;
use App\Http\Controllers\Admin\Finances\SmileController;
use App\Http\Controllers\Admin\Finances\BoostsController;
use App\Http\Controllers\Admin\Package\PackageController;
use App\Http\Controllers\Admin\SubAdmin\SubAdminController;
use App\Http\Controllers\Admin\Challenges\ChallengeController;
use App\Http\Controllers\Admin\Ambassador\AmbassadorController;
use App\Http\Controllers\Admin\Finances\RegistrationController;
use App\Http\Controllers\Admin\Configuration\StickersController;
use App\Http\Controllers\Admin\Configuration\BusinessTypeController;
use App\Http\Controllers\Admin\SpinningWheel\SpinningWheelController;
use App\Http\Controllers\Admin\Configuration\PushAnnouncementController;
use App\Http\Controllers\Admin\AccountCategory\AccountCategoryController;
use App\Http\Controllers\Admin\PromotionalsCodes\PromotionalsCodesController;
use App\Http\Controllers\Admin\Finances\ReportController as FinancesReportController;
use App\Http\Controllers\Admin\NotificationController;

Route::name('auth.')->prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
Route::name('password.')->prefix('password')->group(function () {
    Route::post('/verify', [PassResetController::class, 'create'])->name('verify');
    Route::post('password/validate-token/{token}', [PassResetController::class, 'verify_code'])->name('token');
    Route::post('password/change', [PassResetController::class, 'update_password'])->name('update');
});



Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('home', [AdminController::class, 'home'])->name('home');
    Route::get('/charts', [AdminController::class, 'adminDashboardStatic'])->name('charts.users');
    Route::get('/charts-subs', [AdminController::class, 'adminDashboardSubscription'])->name('charts.subs');

    Route::post('account/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::put('account_update', [AccountController::class, 'update'])->name('account.update');
    Route::post('account_update', [AccountController::class, 'update_password'])->name('account.password');
    Route::get('businesses', [AdminController::class, 'get_businesses'])->name('users.businesses');
    Route::name('notification.')->prefix('notification')->group(function () {
        Route::get('/index', [NotificationController::class, 'index']);
        Route::get('/getNotification', [NotificationController::class, 'getNotification']);
        Route::post('/markAsRead', [NotificationController::class, 'markAsRead'])->name('markRead');
    });

    Route::name('packages.')->prefix('packages')->group(function () {
        Route::get('/{type}', [PackageController::class, 'index'])->name('index')->where('type', 'package|smile');
        Route::get('/{type}/{id}', [PackageController::class, 'show'])->name('show')->where('type', 'package|smile');
        Route::post('/{type}', [PackageController::class, 'store'])->name('store')->where('type', 'package|smile');
        Route::put('/{type}/{id}', [PackageController::class, 'update'])->name('update')->where('type', 'package|smile');
        Route::get('/purchases/{type}', [PackageController::class, 'purchases'])->name('purchases')->where('type', 'packages|smiles');
    });
    Route::name('reports.')->prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
    });
    Route::name('users.')->prefix('users')->group(function () {
        Route::get('/cards', [UserController::class, 'fetchUserCardsGraph'])->name('cards');
        Route::get('/businiss_type', [UserController::class, 'fetchBusinessTypes'])->name('businiss_type');
        Route::get('{id}/stats/challenges', [UserController::class, 'challenges_stats'])->name('challengeStats');
        Route::get('{id}/offers', [UserController::class, 'offers'])->name('offers');
        Route::get('{id}/events', [UserController::class, 'events'])->name('events');
        Route::get('{id}/badges', [UserController::class, 'badges'])->name('badges');
        Route::post('update-status', [UserController::class, 'updateStatus']);
        Route::get('user-medicine/{user}', [UserController::class, 'userMedicine'])->name('usermedcine');
        Route::get('view-medicine/{user}', [UserController::class, 'viewMedicine'])->name('viewMedicine');

        Route::get('user-appointments/{user}', [UserController::class, 'userAppointments'])->name('userAppointments');
        Route::get('user-appointments-details/{user}', [UserController::class, 'userAppointmentsDetails'])->name('userAppointmentsDetails');


        //Medicine
        Route::get('medicine', [MedicineController::class, 'index'])->name('medicine');
        Route::post('medicine', [MedicineController::class, 'store'])->name('medicine.store');
        Route::post('medicine-status', [MedicineController::class, 'updateStatusMedicine']);
        Route::post('medicine-edit/{id}', [MedicineController::class, 'edit'])->name('medicine.edit');

        //Subscription Logs
        Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscriptions');

        //Subscription Plan
        Route::get('subscription-plan', [SubscriptionController::class, 'plan'])->name('plan');
        Route::get('subscription-planOne', [SubscriptionController::class, 'planOne'])->name('planOne');
        Route::post('subscription-edit/{id}', [SubscriptionController::class, 'edit'])->name('plan.edit');
        Route::post('subscription-add', [SubscriptionController::class, 'store'])->name('plan.add');
        Route::post('subscription-delete', [SubscriptionController::class, 'delete'])->name('plan.delete');
    });
    Route::name('challenges.')->prefix('challenges')->group(function () {
        // Route::get('{id}/stats/{type}',[ChallengeController::class,'stats']);
    });
    Route::resources([
        'user' => UserController::class,
        'challenges' => ChallengeController::class,
        'event' => EventsController::class,
        'offer' => OfferController::class,
        'boost' => BoostController::class,
        'ambassador' => AmbassadorController::class,
        'reward' => SpinningWheelController::class,
        'admin' => SubAdminController::class,
        'promotionals' => PromotionalsCodesController::class,
        'pages' => PageController::class,
        'faqs' => FaqsController::class,
        'notification' => NotificationController::class,
    ]);
    Route::get('/spins_reward', [SpinningWheelController::class, 'spinCards'])->name('spins_reward');

    Route::name('finance.')->prefix('finance')->group(function () {
        Route::resources([
            'boost' => BoostsController::class,
            'smile' => SmileController::class,
            'registration' => RegistrationController::class,
            'report' => FinancesReportController::class
        ]);
    });

    Route::name('configuration.')->prefix('configuration')->group(function () {
        Route::resources([
            'category' => AccountCategoryController::class,
            'business_type' => BusinessTypeController::class,
            'stickers' => StickersController::class,
            'announcements' => PushAnnouncementController::class
        ]);
        Route::post('/category_status', [AccountCategoryController::class, 'updateStatus'])->name('category_status');
        Route::post('/business_type_status', [BusinessTypeController::class, 'updateStatus'])->name('business_type_status');
        Route::post('/stickers_status', [StickersController::class, 'updateStatus'])->name('stickers_status');
        Route::get('/account_category', [AccountCategoryController::class, 'fetchAccountCategory'])->name('account_category');
    });
});

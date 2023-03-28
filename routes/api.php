<?php
//

use App\Http\Controllers\Admin\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\Api\Home\FeedController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\Badge\PostController;
use App\Http\Controllers\Api\Badge\BadgeController;
use App\Http\Controllers\Api\Story\StoryController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\Reward\RewardController;
use App\Http\Controllers\Api\Package\PackageController;
use App\Http\Controllers\Api\Business\BusinessController;
use App\Http\Controllers\Api\Business\MedicineController;
use App\Http\Controllers\Api\Reminders\JoggingController;
use App\Http\Controllers\Api\Reminders\StretchController;
use App\Http\Controllers\Api\Reminders\DrinkingController;
use App\Http\Controllers\Api\Challenge\ChallengeController;
use App\Http\Controllers\Api\Reminders\AppointmentController;
use App\Http\Controllers\Api\Reminders\AllRemindersController;
use App\Http\Controllers\Api\Reminders\MedicineReminderController;
use App\Http\Controllers\Api\Boost\FeedController as BoostFeedController;
use App\Http\Controllers\Api\Event\EventController as EventEventController;
use App\Http\Controllers\Api\Offer\OfferController as OfferOfferController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'user'], function () {

        Route::post('signup', [AuthController::class, 'signup']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('send-otp', [AuthController::class, 'sendOtp']);
        Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
        Route::post('verify-signup', [AuthController::class, 'verifySignup']);
        Route::post('verify-token', [AuthController::class, 'verifyToken']);
        Route::post('resend-verification-token', [AuthController::class, 'resendVerificationCode']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::post('create-profile', [AuthController::class, 'createProfile']);
        Route::post('create-patient-profile', [AuthController::class, 'createPatientProfile']);
        Route::get('get-profile', [AuthController::class, 'getProfile']);
        Route::post('edit-profile', [AuthController::class, 'editProfile']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('change-passwords', [AuthController::class, 'changePassword']);

        //Delete api
        Route::post('delete-user', [AuthController::class, 'userDelete']);

        //Medicine
        Route::post('create-medicine', [MedicineController::class, 'createMedicine']);
        Route::get('get-business-list', [BusinessController::class, 'getBusinessList']);
        Route::get('get-artists', [BusinessController::class, 'getArtists']);
        Route::post('delete-medicine', [MedicineController::class, 'deleteMedicine']);


        //Subscription Packages
        Route::get('get-subscription-packages', [PackageController::class, 'getSubscriptionPackages']);
        Route::get('get-subscription-package-detail', [PackageController::class, 'getSubscriptionPackageDetails']);
        Route::post('pay-subscription', [PackageController::class, 'paySubscription']);
        Route::get('get-subscription-logs', [PackageController::class, 'getSubscriptionLogs']);

        //Contact Us
        Route::post('contact-us', [AuthController::class, 'contactUs']);
        Route::get('privacy_policy', [AuthController::class, 'privacyPolicy']);
        Route::get('terms_condition', [AuthController::class, 'termsCondition']);



        //2- Appointment
        Route::get('list-appointment-reminder', [AppointmentController::class, 'listAppointmentReminder']);
        Route::get('getDetails-appointment-reminder', [AppointmentController::class, 'getAppointmentReminder']);
        Route::post('set-appointment-reminder', [AppointmentController::class, 'setAppointmentReminder']);
        Route::post('update-appointment-reminder', [AppointmentController::class, 'updateAppointmentReminder']);
        Route::post('set-appointment-notification', [AppointmentController::class, 'setAppointmentNotification']);


        //3- Drinking
        Route::get('list-drinking-reminder', [DrinkingController::class, 'listDrinkingReminder']);
        Route::post('set-drinking-reminder', [DrinkingController::class, 'setDrinkingReminder']);
        Route::post('update-drinking-reminder', [DrinkingController::class, 'updateDrinkingReminder']);
        Route::post('set-drinking-notification', [DrinkingController::class, 'setDrinkingNotification']);



        //4- Jogging
        Route::post('set-jogging-reminder', [JoggingController::class, 'setJoggingReminder']);
        Route::post('update-jogging-reminder', [JoggingController::class, 'updateJoggingReminder']);
        Route::post('set-jogging-notification', [JoggingController::class, 'setJoggingNotification']);

        //5- Stretch
        Route::post('set-stretch-reminder', [StretchController::class, 'setStretchReminder']);
        Route::post('update-stretch-reminder', [StretchController::class, 'updateStretchReminder']);
        Route::post('set-stretch-notification', [StretchController::class, 'setStretchNotification']);


        //6- All Reminder List

        // this api only search by type
        Route::get('list-reminder', [AllRemindersController::class, 'listReminder']);
        Route::get('list-other-reminder', [AllRemindersController::class, 'listOtherReminder']);
        //mark snooze status
        Route::post('mark-status', [AllRemindersController::class, 'markStatus']);

        Route::post('delete-reminder', [AllRemindersController::class, 'deleteReminder']);

        //change all reminder status
        Route::post('status-reminder', [AllRemindersController::class, 'statusReminder']);


        //6- All Reminder List

        Route::get('getReportDetails', [AllRemindersController::class, 'getReportDetails']);

        // Download Reports
        Route::get('download-report', [AllRemindersController::class, 'downloadReport']);


       

        //10- All Notifications
        Route::get('getNotifications', [NotificationController::class, 'index']);
        Route::post('mark-as-read', [NotificationController::class, 'markAsRead']);
        Route::get('count', [NotificationController::class, 'count']);

        //11- Get Details of Reminder
        Route::get('get-details', [AllRemindersController::class, 'getDetails']);

       

        //13- Interval listing
        Route::get('/getIntervalsTime', function () {
            return ['intervals' => [
                '60',
                '30',
                '15',
                '10',
            ]];
        });

        //14- Remind Me listing
        Route::get('/getRemindMe', function () {
            return ['remind_me' => [
                'Once',
                'Twice',
                'Thrice',
                '4 Times',
                '5 Times',
            ]];
        });
    });
});

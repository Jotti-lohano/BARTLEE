<?php

namespace App\Http\Controllers\Api\Package;

use Carbon\Carbon;
use App\Models\Package;
use App\Traits\StripeCard;
use App\Models\Transaction;
use App\Models\UserPackages;
use Illuminate\Http\Request;
use App\Traits\StripePayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\AdminNotify;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;


class PackageController extends Controller
{
    use StripeCard, StripePayment;
    public function getSubscriptionPackages()
    {
        $packages = Package::latest('id')->get();
        return response()->json(compact('packages'));
    }

    public function getSubscriptionPackageDetails(Request $request)
    {
        $packages_details = Package::where('id', $request->id)->first();
        return response()->json($packages_details);
    }

    // public function paySubscription(Request $request)
    // {

    //     $package = Package::where('id', request('subscription_id'))->first();
    //     $already_purchased = UserPackages::where('user_id', auth()->user()->id)->where('package_id', $package->id)->first();
    //     if ($already_purchased) {
    //         return response()->json(['status' => true, 'msg' => 'Package Already Purchased!']);
    //     }
    //     $stripe_payment = $this->stripe(request('card_number'), request('expiry_month'), request('expiry_year'), request('cvv'), $package->package_amount, auth()->user()->email);
    //     if ($stripe_payment->original['status'] !== 'error') {

    //         DB::beginTransaction();
    //         $user_package = new UserPackages();
    //         $user_package->user_id = \auth()->id();
    //         $user_package->package_id = $package->id;
    //         $user_package->purchase_date = Carbon::now()->format('Y-m-d');
    //         $user_package->expire_date = Carbon::now()->addMonth(12)->format('Y-m-d');
    //         $user_package->save();

    //         $payment = new Transaction();
    //         $payment->description = $stripe_payment->original['data'];
    //         $payment->transactor = \auth()->id();
    //         $payment->transaction_id = $stripe_payment->original['customer'];
    //         $payment->status = 'Paid';
    //         $payment->amount = $package->package_amount;
    //         $payment->transitionable_id = $request->subscription_id;
    //         $payment->save();
    //         $user_package->transaction()->save($payment);

    //         DB::commit();

    //         $admin_notify = Admin::where('id', 1)->first();
    //         Notification::send($admin_notify, new AdminNotify([
    //             'title' => 'New Subscription',
    //             'message' => 'Package Id: ' . $package->id,
    //             'id' => $package->id,
    //             'route' => 'admin.subscription.index',

    //         ]));

    //         return $this->sendResponse($package, __('Successfully Purchased Subscription'));
    //     } else {
    //         return response()->json('Error');
    //     }
    // }


    public function paySubscription(Request $request)

    {
        $validations = Validator::make($request->all(), [
            'package_id' => 'required',
            'device_type' => 'required',
            'android_purchase_token' => 'required_if:device_type,android',
            'receipt_data' => 'required_if:device_type,ios'
        ]);

        if ($validations->fails()) {
            $data = api_validation_errors('Validation Errors', $validations->messages());
            return response()->json($data, 422);
        }

        $package = Package::where('package_id', request('package_id'))->first();
        if ($package) {
            $already_purchased = UserPackages::where('user_id', auth()->user()->id)->where('package_id', request('package_id'))->first();
            if ($already_purchased) {
                return response()->json(['status' => true, 'msg' => 'Package Already Purchased!']);
            }
            if ($request->device_type == 'ios') {

                if ($request->has('receipt_data')) {

                    $ch = curl_init();
                    $url = 'https://sandbox.itunes.apple.com/verifyReceipt';
                    $headers = array(
                        'Content-Type: application/json',
                    );
                    $fields = $request->only('receipt_data');
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    $result = curl_exec($ch);
                    $result = json_decode($result, true);
                    $pending_renewal_info = $result['pending_renewal_info'][0];
                    $original_transaction_id = $pending_renewal_info['original_transaction_id'];
                }
            } else {
                $ch = curl_init();
                $url = 'https://www.googleapis.com/androidpublisher/v3/applications/com.blitzapp.imeds/purchases/subscriptions/'
                    . $request->package_id . '/tokens/' . $request->android_purchase_token;
                $headers = array(
                    'Authorization: application/json',
                );
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                $result = json_decode($result, true);
            }
            DB::beginTransaction();
            $user_package = new UserPackages();
            $user_package->user_id = \auth()->id();
            $user_package->package_id = $package->package_id;
            $user_package->purchase_date = Carbon::now()->format('Y-m-d');
            $user_package->expire_date = Carbon::now()->addMonth(1)->format('Y-m-d');
            $user_package->save();

            //create new transaction
            $payment = new Transaction;
            if ($request->device_type == 'ios') {
                $payment->package_id = $original_transaction_id;
            } else {

                $payment->package_id = $request->package_id;
            }

            $payment->description = 'subscription_purchase';
            $payment->transactor = \auth()->id();
            $payment->transaction_id = $user_package->id;
            $payment->status = 'Paid';
            $payment->amount = $package->package_amount;
            $payment->transitionable_id = $request->package_id;

            if ($request->device_type == 'android') {

                $payment->android_purchase_token = $request->android_purchase_token;
            }
            if ($request->has('receipt_data')) {

                $payment->ios_receipt = $request->get('receipt_data');
            }

            $payment->save();
            $user_package->transaction()->save($payment);



            $getRenewed = Package::where('package_id', $request->package_id)->first();

            //get transation for update end time
            $getTransaction = UserPackages::where('package_id', $user_package->id)->first();
            $current_time = Carbon::now();
            if ($getRenewed) {

                if (str_contains(strtolower($getRenewed->type), 'Monthly')) {

                    $getTransaction->expire_date =  Carbon::now()->addMonth(1)->format('Y-m-d');
                    $getTransaction->save();
                }
                if (str_contains(strtolower($getRenewed->type), 'Yearly')) {
                    $getTransaction->expire_date =  Carbon::now()->addYear(1)->format('Y-m-d');
                    $getTransaction->save();
                }
            }
            DB::commit();

            $subscription = UserPackages::with('package')->where('user_id', auth()->user()->id)->latest()->first();

            $data = api_successWithData('Subscription purchased succesfully', $subscription);

            $admin_notify = Admin::where('id', 1)->first();
            Notification::send($admin_notify, new AdminNotify([
                'title' => 'New Subscription',
                'message' => 'Package Id: ' . $request->package_id,
                'id' => $request->package_id,
                'route' => 'admin.subscription.index',

            ]));

            return $this->sendResponse($package, __('Successfully Purchased Subscription'));
        } else {
            $data = api_error('Package Not Found!');
            return response()->json($data);
        }
    }

    public function getSubscriptionLogs()
    {
        $subscriptionLogs = UserPackages::with('package')->where('user_id', auth()->user()->id)->get();
        return response()->json(compact('subscriptionLogs'));
    }

    public function sendResponse($result = 'null', $message)
    {
        $response = [
            'status' => 'Success',
            'message' => $message ?? null,
            'data' => $result,
        ];

        return response($response, 200);
    }
}

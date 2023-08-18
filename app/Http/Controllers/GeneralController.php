<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Features;
use App\Models\ContactUs;
use App\Models\UserArtist;

use App\Traits\StripeCard;
use App\Models\Transaction;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Traits\StripePayment;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\paymentResource;
use App\Http\Resources\FeedBackResource;

class GeneralController extends Controller
{
    use StripeCard, StripePayment;

        public function getFeedback(Request $request)
        {
            $feedbacks = ContactUs::
            when(request()->filled('from'), function($q) {
                $q->whereDate('created_at', '>=', request('from'))->whereDate('created_at', '<=', request('to'));
              })
              ->when(request()->filled('search'), function($q) {
                $q->where(function($q) {
                    $q->where('firstname', 'like', '%'.request("search").'%')
                    ->orWhere('lastname', 'like', '%'.request("search").'%')
                    ->orWhere('email', 'like', '%'.request("search").'%')
                    ->orWhere('subject', 'like', '%'.request("search").'%');
                });
              })  
           ->paginate(request('entries'));
            return $this->response->success(
                FeedBackResource::collection($feedbacks) );
          
        }

        public function getFeedbackDetail(Request $request)
        {
            $user =  ContactUs::where('id',$request->id)->first();

            return $this->response->success(
              new FeedBackResource($user)
          );
        }

        public function getFeatures(Request $request )
        {
            $feature = Features::with('FeatureList')->first();

            return $this->response->success(
                new DefaultResource($feature)
            );
        }

        public function FeaturePayment(Request $request)
        {
           $feature_expiry_date =  Carbon::now()->addDays(3);
           
            if (!auth('api')->check()) {
                return api_error('Message: Login required');
            }
      
            $expire = 60;

            $stripe_payment = $this->stripe(request('card_number'), request('expiry_month'), request('expiry_year'), request('cvv'), request('amount'), auth()->user()->email);
            if ($stripe_payment->original['status'] !== 'error') {
    
               
           
                $user = UserProfile::where('user_id',auth()->user()->id)->first();
               
                $artist =  UserArtist::where('user_profile_id',$user->id)->first();
              //  return $artist;
               $data = $artist->paymentTransaction()->create([
                    'amount' => $request->amount,
                    'description' => $stripe_payment->original['data'],
                    'transactor' => $artist->id,
                    'transaction_id' => $stripe_payment->original['customer'],
                    'status' => 'Paid',
                    'package_id' => $request->feature_id,
                    'feature_expiry_date' =>  $feature_expiry_date,
                ]);
               
                    
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'message' => 'Payment Paid Successfully'
                ],200);
                
            }else {
                return $stripe_payment;
            }  
        }


        public function renewFeature(Request $request)
        {
            $feature_expiry_date =  Carbon::now()->addDays(3);
            
             if (!auth('api')->check()) {
                 return api_error('Message: Login required');
             }
       
             $expire = 60;
 
             $stripe_payment = $this->stripe(request('card_number'), request('expiry_month'), request('expiry_year'), request('cvv'), request('amount'), auth()->user()->email);
             if ($stripe_payment->original['status'] !== 'error') {
     
                
            
                 $user = UserProfile::where('user_id',auth()->user()->id)->first();
                   //return $user;
                 $artist =  UserArtist::where('user_profile_id',$user->id)->first();
              
                $result = $artist->paymentTransaction()->delete();
         
               //  return $artist;
                $data = $artist->paymentTransaction()->create([
                     'amount' => $request->amount,
                     'description' => $stripe_payment->original['data'],
                     'transactor' => $artist->id,
                     'transaction_id' => $stripe_payment->original['customer'],
                     'status' => 'Paid',
                     'package_id' => $request->feature_id,
                     'feature_expiry_date' =>  $feature_expiry_date,
                 ]);
                
                     
                 return response()->json([
                     'success' => true,
                     'status_code' => 200,
                     'message' => 'Payment Paid Successfully'
                 ],200);
                 
             }else {
                 return $stripe_payment;
             }  
         }
        public function paymentLogs(Request $request)
        {


           $log = Transaction::with('Feature:id,title,price,day','UserArtist:id,user_profile_id,is_featured')

           ->when(request()->filled('from'), function($q) {
            $q->whereDate('created_at', '>=', request('from'))->whereDate('created_at', '<=', request('to'));
          })
          ->when(request()->filled('search'), function($q) {
            $q->where(function($q) {
                $q->where('amount', 'like', '%'.request("search").'%');
               
            });
            $q->whereHas('UserArtist.UserProfile', function($query){
                $query->where('name', 'like', '%'.request("search").'%');
           
            });
          })
           ->paginate(request('entries'));
           

           return $this->response->success(
            paymentResource::collection($log) );

        }
}

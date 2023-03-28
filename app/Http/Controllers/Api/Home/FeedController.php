<?php

namespace App\Http\Controllers\Api\Home;

use App\Models\Badge;
use App\Models\Event;
use App\Models\Offer;
use App\Models\BadgePost;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        // Get All Followings
        $followings = auth('api')->user()->followings()->get();
        $pagination = false;


        $user = $business = [];

        foreach($followings as $following) {
            if($following->user_type == 'user') {
                $user[] = $following->id;
            } else if ($following->user_type == 'business') {
                 $id = $following->business_user()->pluck('id');
                 $business[] = $id[0];
            }
        }

        $data['user'] = $user;
        $data['business'] = $business;

        // return api_success('Business Visitor', $data);
        
        // Get Following Post
        $post = BadgePost::select('*', DB::raw('"post" as model_type'))->whereIn('user_id', $user)->orWhere(function($q) use ($business){
            $q->whereIn('badge_id', $business);
        })->with(['business' => function($q) {
            $q->withCount(['is_saved' => function($q) {
                            $q->where('user_id', request()->user()->id);
                        }]);
        }, 'business.badge', 'business.user.city', 'user.city', 'mentions.user'])->orderBy('created_at', 'DESC')
        // ->withCount('buisness')
        ->paginate(10);

        if(!$pagination) {
            $pagination = $post->total() > $post->perPage()*$post->currentPage() ? true : false;
        }

        
        // return api_success('Business Visitor', $post);
        // Get Following Events
        $events = Event::select('*', DB::raw('"event" as model_type'))->whereIn('business_id', $business)->with(['media', 'business.user.city'])->orderBy('created_at', 'DESC')->paginate(10);

        if(!$pagination) {
            $pagination = $events->total() > $events->perPage()*$events->currentPage() ? true : false;
        }

        // return api_success('Business Visitor', $events);
        // Get Following Offer
        $offers = Offer::select('*', DB::raw('"offer" as model_type'))->whereIn('business_id', $business)->with('business.user.city')->orderBy('created_at', 'DESC')->paginate(10);

        if(!$pagination) {
            $pagination = $offers->total() > $offers->perPage()*$offers->currentPage() ? true : false;
        }

        // return api_success('Business Visitor', $offers);
        // Get Following Challenge
        $challenges = Challenge::select('*', DB::raw('"challenge" as model_type'))->whereIn('business_id', $business)->with('business.user.city')->orderBy('created_at', 'DESC')->paginate(10);

        if(!$pagination) {
            $pagination = $challenges->total() > $challenges->perPage()*$challenges->currentPage() ? true : false;
        }

        
        $merged = $events->merge($offers)->merge($post)->merge($challenges);
        // $merged = $merged->merge($post);
        // $merged = $merged->merge($challenges);

        $sorted = $merged->sortByDesc('created_at')->toArray();        
        $sorted = array_values($sorted);

        $ar['page'] = $pagination;
        $ar['data'] = $sorted;
        return api_success('Feeds data', $ar);
    }

}

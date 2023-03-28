<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserGroup;
use App\Models\BadgeGroup;
use App\Models\BusinessType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UserSticker;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        $user = User::where('id', $user->id)
                        ->with(['user_badges.badge' => function($q) use ($user){
                            $q->with(['badge_media', 'user.city'])->withCount(['logs' => function($q) use ($user) {
                                $q->where('user_id', $user->id);
                            }]);
                        },  'user_groups', 'city'])
                        ->withCount('user_badges', 'commonBadges')
                        ->get();


        // $cities = UserBadge::select(DB::raw("count(business_logs.id) as visit"), 'cities.name as city_name', 'user_businesses.business_name', 'users.city_id as city_id', 'cities.latitude as latitude', 'cities.longitude as longitude', 'user_badges.badge_id as badge_id', 'user_businesses.business_name as badge_name', 'media.path as path', 'users.username as username', 'user_businesses.address as address', 'user_businesses.lat as lat', 'user_businesses.lng as lng')
        //         ->leftJoin('user_businesses', 'user_badges.badge_id', 'user_businesses.id')
        //         ->leftJoin('media', function($q) {
        //             $q->on('user_businesses.id', 'media.fileable_id')->where('data->type', 'badge');
        //         })
        //         ->leftJoin('users', 'user_businesses.business_id', 'users.id')
        //         ->leftJoin('cities', 'cities.id', 'users.city_id')
        //         ->leftJoin('business_logs', function($q) use ($user){
        //             $q->on('business_logs.business_id', 'user_businesses.id')->where('business_logs.user_id', $user[0]->id);
        //         })
        //         ->where('user_badges.user_id', $user[0]->id)
        //         ->whereNotNull('cities.id')
        //         ->groupBy('badge_id')
        //         ->get();
        
        $temp = [];
        $data = [];
        $i = 0;
        foreach($cities as $city) {
            if(!in_array($city->city_id, $temp)) {
                array_push($temp, $city->city_id);
                $data[$i]['city_id'] = $city->city_id;
                $data[$i]['city_name'] = $city->city_name;
                $data[$i]['lat'] = $city->latitude;
                $data[$i]['lng'] = $city->longitude;
                $data[$i]['badge'][0]['badge_id'] = $city->badge_id;
                $data[$i]['badge'][0]['badge_name'] = $city->badge_name;
                $data[$i]['badge'][0]['badge_image'] = asset(\Storage::url("media/$city->path"), false);
                $data[$i]['badge'][0]['address'] = $city->address;
                $data[$i]['badge'][0]['city'] = $city->city_name ? $city->city_name : '';
                $data[$i]['badge'][0]['business_name'] = $city->business_name ? $city->business_name : '';

                $data[$i]['badge'][0]['lat'] = $city->lat;
                $data[$i]['badge'][0]['lng'] = $city->lng;
                $data[$i]['badge'][0]['visits'] = $city->visit;

                $i++;
            }else {
                $index = array_search($city->city_id, $temp);                
                $nestedIndex = count($data[$index]['badge']);
                $data[$index]['badge'][$nestedIndex]['badge_id'] = $city->badge_id;  
                $data[$index]['badge'][$nestedIndex]['badge_name'] = $city->badge_name;  
                $data[$index]['badge'][$nestedIndex]['badge_image'] = asset(\Storage::url("media/$city->path"), false);
                $data[$index]['badge'][$nestedIndex]['address'] = $city->address; 
                $data[$index]['badge'][$nestedIndex]['city'] = $city->city_name ? $city->city_name : '';
                $data[$index]['badge'][$nestedIndex]['business_name'] = $city->business_name ? $city->business_name : '';
                $data[$index]['badge'][$nestedIndex]['lat'] = $city->lat; 
                $data[$index]['badge'][$nestedIndex]['lng'] = $city->lng; 
                $data[$index]['badge'][$nestedIndex]['visits'] = $city->visit;
            }
        }

        $data = array_values($data);

        $dt['user'] = $user;
        $dt['cities'] = $data;


        $groupIds = [];
        // Groups work start here
        if(count($user[0]->user_groups) > 0) {
            foreach($user[0]->user_groups as $group) {
                $groupIds[] = $group->id;
            }
        }

        $groups = BadgeGroup::select('badge_group.id as bid', DB::raw("count(business_logs.id) as visit"), 'user_businesses.business_name', 'cities.name as city_name', 'badge_group.group_id as group_id', 'badge_group.badge_id as badge_id', 'user_groups.name as group_name', 'user_groups.image as image_url', 'user_businesses.business_name as badge_name', 'media.path as path', 'users.username as username', 'user_businesses.address as address', 'user_businesses.lat as lat', 'user_businesses.lng as lng')
                ->leftJoin('user_businesses', 'badge_group.badge_id', 'user_businesses.id')
                ->leftJoin('media', function($q) {
                    $q->on('user_businesses.id', 'media.fileable_id')->where('data->type', 'badge');
                })
                ->leftJoin('business_logs', function($q) use ($user){
                    $q->on('business_logs.business_id', 'user_businesses.id')->where('business_logs.user_id', $user[0]->id);
                })
                ->leftJoin('users', 'user_businesses.business_id', 'users.id')
                ->leftJoin('cities', 'cities.id', 'users.city_id')
                ->leftJoin('user_groups', 'user_groups.id', 'badge_group.group_id')
                ->whereIn('group_id', $groupIds)
                // ->whereNotNull('user_businesses.id')
                ->groupBy('bid')
                ->get();
        

        //  dd($groups);

        $temp = [];
        $data = [];
        $i = 0;
        foreach($groups as $group) {
            
            if(!in_array($group->group_id, $temp)) {
                array_push($temp, $group->group_id);                              
                $data[$i]['group_id'] = $group->group_id;
                $data[$i]['group_name'] = $group->group_name;
                $data[$i]['image'] = $group->image_url;
                $data[$i]['badge'][0]['badge_id'] = $group->badge_id ? $group->badge_id : '';
                $data[$i]['badge'][0]['badge_name'] = $group->badge_name ? $group->badge_name : '';
                $data[$i]['badge'][0]['badge_image'] = $group->path ? asset(\Storage::url("media/$group->path"), false) : '';
                $data[$i]['badge'][0]['address'] = $group->address ? $group->address : '';
                $data[$i]['badge'][0]['city'] = $group->city_name ? $group->city_name : '';
                $data[$i]['badge'][0]['business_name'] = $group->business_name ? $group->business_name : '';
                $data[$i]['badge'][0]['lat'] = $group->lat ? $group->lat : '';
                $data[$i]['badge'][0]['lng'] = $group->lng ? $group->lng : '';
                $data[$i]['badge'][0]['visit'] = $group->visit ? $group->visit : 0;

                $i++;
            }else {
                // dd($index);
                $index = array_search($group->group_id, $temp);  
                
                $nestedIndex = count($data[$index]['badge']);
                $data[$index]['badge'][$nestedIndex]['badge_id'] = $group->badge_id ? $group->badge_id : '';
                $data[$index]['badge'][$nestedIndex]['badge_name'] = $group->badge_name ? $group->badge_name : '';
                $data[$index]['badge'][$nestedIndex]['badge_image'] = $group->path ? asset(\Storage::url("media/$group->path"), false) : '';
                $data[$index]['badge'][$nestedIndex]['address'] = $group->address ? $group->address : '';
                $data[$index]['badge'][$nestedIndex]['city'] = $group->city_name ? $group->city_name : '';
                $data[$index]['badge'][$nestedIndex]['business_name'] = $group->business_name ? $group->business_name : '';
                $data[$index]['badge'][$nestedIndex]['lat'] = $group->lat ? $group->lat : '';
                $data[$index]['badge'][$nestedIndex]['lng'] = $group->lng ? $group->lng : '';
                $data[$index]['badge'][$nestedIndex]['visit'] = $group->visit ? $group->visit : 0;
            }
        }

        $dt['groups'] = $data;
        if(auth('api')->user()->id != $user[0]->id) {
            $dt['user'][0]['following'] = auth('api')->user()->IFollow($user[0]->id);
	    $dt['user'][0]['follows_me'] = auth('api')->user()->isFollowMe($user[0]->id);
        }

        if(auth('api')->user()->id != $user[0]->id && $user[0]->is_public == 0) {
            $dt['user'][0]['requested'] = auth('api')->user()->requested($user[0]->id);
        }


        return api_success('profile data', $dt);
    }

    public function interest(Request $request)
    {
        $businessTypes = BusinessType::select('business_types.*', DB::raw('GROUP_CONCAT(user_businesses.id) as business_ids'))
                        ->leftJoin('users', 'users.business_type_id', 'business_types.id')
                        ->leftJoin('user_businesses', 'user_businesses.business_id', 'users.id')
                        ->leftJoin('user_badges', 'user_businesses.id', 'user_badges.badge_id')
                        ->groupBy('business_types.id')
                        ->where('user_badges.user_id', auth('api')->user()->id)
                        ->get();        
        
        
        
        // $data['categories'] = Category::whereIn('id', $businessTypes->pluck('category_id'))->get();

        $businessIds = '';
        
        foreach($businessTypes as $key => $bt) {
            $businessIds .= $bt->business_ids.',';            
            $businessTypes[$key]['stickers'] = UserSticker::select('*', \DB::raw('count(id) as total'))->with('sticker')->whereIn('business_id', explode(',', $businessIds))->groupBy('sticker_id')->orderBy('total', 'DESC')->get();            
        }
        $data['business_types'] = $businessTypes;
        return api_success('profile data', $data);
    }

    public function UserInterest(Request $request, $user)
    {
        $businessTypes = BusinessType::select('business_types.*', DB::raw('GROUP_CONCAT(user_businesses.id) as business_ids'))
                        ->leftJoin('users', 'users.business_type_id', 'business_types.id')
                        ->leftJoin('user_businesses', 'user_businesses.business_id', 'users.id')
                        ->leftJoin('user_badges', 'user_businesses.id', 'user_badges.badge_id')
                        ->groupBy('business_types.id')
                        ->where('user_badges.user_id', $user)
                        ->get();        
        
        
        
        // $data['categories'] = Category::whereIn('id', $businessTypes->pluck('category_id'))->get();

        $businessIds = '';
        
        foreach($businessTypes as $key => $bt) {
            $businessIds .= $bt->business_ids.',';            
            $businessTypes[$key]['stickers'] = UserSticker::select('*', \DB::raw('count(id) as total'))->with('sticker')->whereIn('business_id', explode(',', $businessIds))->groupBy('sticker_id')->orderBy('total', 'DESC')->get();            
        }
        $data['business_types'] = $businessTypes;
        return api_success('profile data', $data);
    }

    public function visibility(Request $request)
    {
        auth('api')->user()->is_public = (int) $request->is_public;
        auth('api')->user()->save();

        return api_success("Updated", ['data' => auth('api')->user() ]);
    }

    public function unreadNotification()
    {
        $notification = auth('api')->user()->unreadNotifications;

        return api_success('unread notification', $notification);
    }
    
    public function notification()
    {
        $notification = auth('api')->user()->notifications;

        return api_success('notification', $notification);
    }

    public function markAllRead()
    {
        auth('api')->user()->unreadNotifications->markAsRead();
        return api_success1('Marked all notification successfully');
    }

}

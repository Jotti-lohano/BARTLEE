<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    protected $fillable = ['username', 'email', 'password', 'phone', 'user_type', 'avatar', 'country_code', 'first_name', 'last_name', 'soa_chat_id', 'status', 'device_token', 'device_type'];
    protected $appends = ['avatar_url', 'status_detail', 'token', 'profile_complete', 'subscribed'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $statuses = [
        0 => 'Inactive',
        1 => 'Active',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUsernameAttribute($value)
    {
        return ucfirst($value);
    }

    public function user_subscription()
    {
        return $this->hasMany(UserPackages::class, 'user_id');
    }

    public function user_profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }

    //    protected static function boot(){
    //        parent::boot();
    //        self::created(function(User $user){
    //		if($user->user_type == 'business') {
    //	                $user->business_user()->create([
    //	                    'business_id' => $user->id,
    //	                ]);
    //            	}
    //	});
    //    }

    //    public function profile_complete()
    //    {
    //        return $this->hasOne(UserProfile::class,'user_id');
    //    }
    //
    //    public function business_events()
    //    {
    //        return $this->hasMany(Event::class,'business_id');
    //    }
    //
    //    public function user_challenges()
    //    {
    //        return $this->hasMany(UserChallenge::class,'user_id');
    //    }
    //
    //    public function user_offers()
    //    {
    //        return $this->hasMany(UserOffer::class,'user_id');
    //    }
    //
    //    public function offers()
    //    {
    //        return $this->hasManyThrough(Offer::class, UserBusiness::class, 'business_id', 'business_id', 'id', 'id');
    //    }
    //
    //    public function challenges()
    //    {
    //        return $this->hasManyThrough(Challenge::class, UserBusiness::class, 'business_id', 'business_id', 'id', 'id');
    //    }
    //
    //    public function badges()
    //    {
    //        return $this->hasMany(Badge::class);
    //    }
    //
    //
    //    public function followers()
    //    {
    //        return $this->belongsToMany(User::class, 'followers', 'leader_id', 'follower_id')->where('followers.status', 1)->withTimestamps();
    //    }
    //
    //    public function followerRequests()
    //    {
    //        return $this->belongsToMany(User::class, 'followers', 'leader_id', 'follower_id')->where('followers.status', 2)->withTimestamps();
    //    }
    //
    //    public function  IFollow($user_id) {
    //        return Follower::where('leader_id', $user_id)->where('follower_id', auth('api')->user()->id)->where('status', 1)->exists();
    //    }
    //
    //    public function requested($user_id) {
    //        return Follower::where('leader_id', $user_id)->where('follower_id', auth('api')->user()->id)->where('status', 2)->exists();
    //    }
    //
    //    public function isFollowMe($user_id) {
    //        return Follower::where('follower_id', $user_id)->where('leader_id', auth('api')->user()->id)->where('status', 1)->exists();
    //    }
    //
    //    public function followings()
    //    {
    //        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'leader_id')->where('followers.status', 1)->withTimestamps();
    //    }
    //
    //    public function user_badges()
    //    {
    //        return $this->hasMany(UserBadge::class);
    //    }
    //
    //    public function user_groups()
    //    {
    //        return $this->hasMany(UserGroup::class);
    //    }
    //
    //    public function did_you_knows()
    //    {
    //        return $this->hasMany(DidYouKnow::class,'business_id');
    //    }
    //
    //    public function user_did_you_knows()
    //    {
    //        return $this->hasMany(UserDidYouKnow::class);
    //    }
    //
    //    public function city()
    //    {
    //        return $this->belongsTo(City::class);
    //    }
    //
    //    public function country()
    //    {
    //        return $this->belongsTo(Country::class);
    //    }
    //
    //    public function friends()
    //    {
    //        return $this->belongsToMany(self::class, 'friends', 'user_id', 'friend_id')->wherePivot('accepted', '=', 1);
    //        // if you want to rely on accepted field, then add this:
    //        //->wherePivot('accepted', '=', 1);
    //    }
    //
    //    public function friend_requests()
    //    {
    //        return $this->belongsToMany(self::class, 'friends', 'user_id', 'friend_id')->wherePivot('accepted', '=', 0);
    //    }
    //
    //    public function user_stickers()
    //    {
    //        return $this->hasMany(UserSticker::class, 'user_id');
    //    }
    //
    //    public function business_user()
    //    {
    //        return $this->hasOne(UserBusiness::class,'business_id');
    //    }
    //
    //
    //    public function user_business_types()
    //    {
    //        return $this->hasMany(UserBusinessType::class);
    //    }
    //
    //    public function business_type()
    //    {
    //        return $this->belongsTo(BusinessType::class);
    //    }
    //
    //    public function category()
    //    {
    //        return $this->belongsTo(Category::class);
    //    }
    //
    //    public function business()
    //    {
    //        return $this->belongsTo(User::class, 'id');
    //    }
    //
    //    /*public function business_type_data()
    //    {
    //        return $this->belongsTo(BusinessType::class, 'business_type_id');
    //    }*/
    //
    //    public function orders()
    //    {
    //        return $this->hasMany(Order::class, 'user_id','id')->with('orderDetails');
    //    }
    //
    //
    //    public function business_tags()
    //    {
    //        return $this->hasMany(UserTag::class)->where('user_type','business');
    //    }
    //    public function smiles() {
    //
    //		return $this->hasMany(UserSmile::class, 'user_id');
    //	}
    //    public function wallet() {
    //
    //		return $this->hasMany(Wallet::class, 'user_id');
    //	}
    //    public function chargeSmiles($smiles, $type = 'in', $columns = []) {
    //
    //		$columns = $columns + [
    //			'value' => $smiles,
    //			'type'   => $type,
    //		];
    //		return $this->smiles()->create($columns);
    //	}
    //
    //    public function chargeWallet($value, $type = 'in', $columns = []) {
    //
    //		$columns = $columns + [
    //			'value' => $value,
    //			'flow'   => $type,
    //		];
    //		return $this->wallet()->create($columns);
    //	}
    //
    //    public function getSmilesBalanceAttribute(){
    //        return getSmilesBalanace($this->id);
    //    }
    //
    //    public function getCreditsAttribute(){
    //        return getWalletBalanace($this->id,'credit');
    //    }
    //
    //    public function setCodeAttribute(){
    //        $this->attributes['code'] = generateTicketID(0,6);
    //    }
    //
    //    public function getLocationAttribute()
    //    {
    //        $city = City::select('name')->find($this->city_id);
    //        $city_name = $city ? $city->name:'';
    //        $country = Country::select('name')->find($this->country_id);
    //        $country_name = $country ? $country->name:'';
    //        return "{$city_name} {$country_name}";
    //    }


    public function getAvatarUrlAttribute()
    {
        return asset("/storage/user/avatar/{$this->avatar}", false);
    }

    public function storeAvatar()
    {
        if (request()->hasFile('image')) {
            $file = storage_path('public/media' . $this->avatar);
            if (is_file($file) && file_exists($file)) {
                unlink($file);
            }
            $path = $file->store('public/media');
            $this->avatar = basename($path);
        }
    }

    //    public function profile() {
    //        return $this->user_badges()->whereIn('badge_id', $this->getBadgeIds() );
    //    }
    //
    //    public function getBadgeIds() {
    //        $ids = [];
    //        $badges = auth('api')->user()->load('user_badges');
    //        $badges = $badges->user_badges;
    //
    //        foreach($badges as $badge) {
    //            $ids[] = $badge->badge_id;
    //        }
    //
    //        return $ids;
    //    }

    public function getStatusDetailAttribute()
    {
        return $this->statuses[$this->status];
    }

    //    public function saved_businesses()
    //    {
    //        return $this->hasMany(BusinessLog::class,'user_id', 'id')->where('type', 'save');
    //    }

    public function getTokenAttribute()
    {
        return encrypt($this->id);
    }
    public function getProfileCompleteAttribute()
    {
        $check = UserProfile::where('user_id', $this->id)->first();
        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    public function getSubscribedAttribute()
    {
        $check = UserPackages::where('user_id', $this->id)->first();
        if ($check) {
            return true;
        } else {
            return false;
        }
    }
}

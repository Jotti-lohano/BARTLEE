<?php

namespace App\Models;

use App\Models\Profession;
use App\Models\ArtistSkills;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'location', 'gender', 'email', 'phone', 'user_type', 'country_code'];

    protected $table = 'user_profile';

    protected $appends = ['avatar_url', 'subscribed'];

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

    public function subscription()
    {
        return $this->hasMany(UserPackages::class, 'user_id', 'user_id');
    }

    public function getSubscribedAttribute()
    {
        $check = UserPackages::where('user_id', $this->user_id)->first();
        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    public function user_business_detail()
    {
        return $this->hasOne(business_details::class, 'user_profile_id');
    }

    public function artist_skills()
    {
        return $this->hasMany(ArtistSkills::class, 'user_profile_id');
    }

    public function artist_work()
    {
        return $this->hasMany(ArtistWork::class, 'user_profile_id');
    }
    public function UserArist()
    {
        return $this->hasMany(UserArtist::class, 'user_profile_id');
    }

  

}

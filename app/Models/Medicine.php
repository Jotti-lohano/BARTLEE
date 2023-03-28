<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $table = 'medicine';

    protected $guarded = [];

    protected $fillable = ['created_by','medicine_name','medicine_type','medicine_color','potency_volume_medicine','medicine_quantity','before_afterMeal','interval', 'notes','medicine_picture', 'medicine_prescription_picture','status'];
    protected $appends = ['medicine_picture_url','medicine_prescription_url'];
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
        0 => 'Inative',
        1 => 'Active',
    ];

    public function getMedicinePictureUrlAttribute(){
        return asset("storage/user/avatar/{$this->medicine_picture}", false);
    }
    public function getMedicinePrescriptionUrlAttribute(){
        return asset("storage/user/avatar/{$this->medicine_prescription_picture}", false);
    }

    public function med_creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }


    public function storeMedicinePicture(){
        if(request()->hasFile('image')){
            $file = storage_path('public/media'.$this->medicine_picture);
            if(is_file($file) && file_exists($file)){
                unlink($file);
            }
            $path = $file->store('public/media');
            $this->medicine_picture = basename($path);
        }
    }

    public function storeMedicinePrescription(){
        if(request()->hasFile('image')){
            $file = storage_path('public/media'.$this->medicine_prescription_picture);
            if(is_file($file) && file_exists($file)){
                unlink($file);
            }
            $path = $file->store('public/media');
            $this->medicine_prescription_picture = basename($path);
        }
    }
}

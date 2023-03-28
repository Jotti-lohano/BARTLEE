<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['name','path','data'];

    protected $casts = [
        'data' => 'array',
    ];
    protected $appends = [
        'file_url',
    ];

    public function getFileUrlAttribute(){
        return asset(\Storage::url("media/$this->path"), false);
    }
}

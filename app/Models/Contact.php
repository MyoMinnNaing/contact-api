<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["name", "country_code", "phone_number", "user_id"];


    // public function favoritedBy()
    // {
    //     return $this->belongsToMany(User::class, 'favorites', 'contact_id', 'user_id');
    // }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchRecord extends Model
{
    use HasFactory;

    protected $fillable = ['keyword', 'user_id'];



    public function users()
    {
        return $this->belongsToMany(User::class, 'user_search_records');
    }
}

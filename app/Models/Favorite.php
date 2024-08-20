<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['content_id', 'user_id', 'type']; // register fields to take in create/update functions
    /**/
    /* defining a one to one relationship with user table so the user can have own favorites movies/series     */
    /**/
    public function user() //
    {
        return $this->belongsTo(User::class);
    }
}

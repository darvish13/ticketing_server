<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id', 'title', 'text'
    ];

    function user() {
        return $this->belongsTo('App\User');
    }
}

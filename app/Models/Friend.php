<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    public $timestamps = false;

    protected $fillable =[
        'userid',
        'friend_userid',
        'status',
    ];

    public function sender(){
        return $this->belongsTo(User::class,'userid');
    }
    public function receiver(){
        return $this->belongsTo(User::class,'friend_userid');
    }
}

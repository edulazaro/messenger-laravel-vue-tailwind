<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];
    protected $with = ['user', 'fromUser', 'toUser'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function fromUser()
    {
        return $this->belongsTo('App\User', 'from');
    }

    public function toUser()
    {
        return $this->belongsTo('App\User', 'to');
    }
}

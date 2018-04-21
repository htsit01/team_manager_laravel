<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowUpCustomer extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
}

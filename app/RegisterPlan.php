<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterPlan extends Model
{
    public function region(){
        return $this->hasOne('App\CustomerArea');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}

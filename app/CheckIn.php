<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function shop(){
        return $this->belongsTo('App\Customer');
    }

    public function plan(){
        return $this->belongsTo('App\ListPlan');
    }
}
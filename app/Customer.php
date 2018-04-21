<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function region()
    {
        return $this->belongsTo('App\CustomerArea');
    }

    public function list_plan(){
        return $this->belongsTo('App\ListPlan');
    }

    public function credit_form(){
        return $this->hasOne('App\CreditForm');
    }

    public function checkins(){
        return $this->hasMany('App\CheckIn');
    }

    public function checkouts(){
        return $this->hasMany('App\CheckOut');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerArea extends Model
{
    public function shops(){
        return $this->hasMany('App\Customer');
    }

    public function register_plan(){
        return $this->belongsTo('App\RegisterPlan');
    }

    public function users(){
        return $this->hasMany('App\User')->withTimestamps();
    }
}

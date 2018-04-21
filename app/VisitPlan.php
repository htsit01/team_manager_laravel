<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitPlan extends Model
{
    public function list_plans(){
        return $this->hasMany('App\ListPlan');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function verification(){
        return $this->belongsTo('App\Verification');
    }
}

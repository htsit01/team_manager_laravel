<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListPlan extends Model
{
    public function visit_plan(){
        return $this->belongsTo('App\VisitPlan');
    }

    public function shop(){
        return $this->hasOne('App\Customer');
    }

    public function checkins(){
        return $this->hasOne('App\CheckIn');
    }
    public function checkouts(){
        return $this->hasOne('App\CheckIn');
    }
}

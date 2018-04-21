<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function visit_plan(){
        return $this->belongsTo('App\VisitPlan');
    }
//    public function verify(){
//        return $this->belongsTo('App\User', 'user_two_id','id');
//    }
//
//    public function verifiedby(){
//        return $this->belongsTo('App\User', 'user_one_id','id');
//    }
}

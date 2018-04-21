<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','locations','checkins','checkouts'
    ];


    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function register_plans(){
        return $this->hasMany('App\RegisterPlan');
    }

    public function visit_plans(){
        return $this->hasMany('App\VisitPlan');
    }

    public function locations(){
        return $this->hasMany('App\Location');
    }

    public function checkins(){
        return $this->hasMany('App\Checkin');
    }

    public function checkouts(){
        return $this->hasMany('App\Checkout');
    }

    public function follow_ups(){
        return $this->hasMany('App\FollowUp');
    }

    public function follow_up_customers(){
        return $this->hasMany('App\FollowUpCustomer');
    }

//    public function verify(){
//        return $this->hasMany('App\Verification', 'user_one_id');
//    }
//    public function verifiedby(){
//        return $this->hasMany('App\Verification', 'user_two_id');
//    }

    public function group(){
        return $this->belongsTo('App\Group');
    }

//    public function customer_areas(){
//        return $this->belongstoMany('App\CustomerArea','customer_area_users')->withTimestamps();
//    }

    public function customer_areas(){
        return $this->belongsTo('App\CustomerArea');
    }

    public function verification(){
        return $this->hasMany('App\Verification');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function users(){
        return $this->hasMany('App\User');
    }

    public function members(){
        return $this->users()->whereIn('role_id', [5,6,7]);
    }

    public function leader(){
        return $this->users()->whereIn('role_id', [2,3,4])->first();
    }
}

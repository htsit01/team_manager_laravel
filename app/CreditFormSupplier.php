<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditFormSupplier extends Model
{
    public function credit_form(){
        return $this->belongsTo('App\CreditForm');
    }
}

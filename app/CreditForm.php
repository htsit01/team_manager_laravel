<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditForm extends Model
{
    public function shop(){
        return $this->belongsTo('App\Customer');
    }

    public function credit_form_suppliers(){
        return $this->hasMany('App\CreditFormSupplier');
    }
}

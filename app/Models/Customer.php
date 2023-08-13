<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function vehicles()
    {
        $instance = $this->hasMany('App\Models\CustomerVehicleCredential','customer_id','id');
        return $instance;
    }
}

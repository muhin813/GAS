<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageDetail extends Model
{
    protected $guarded = [];

    public function sub_details()
    {
        $instance = $this->hasMany('App\Models\PackageSubDetail','package_details_id','id');
        $instance = $instance->where('status','active');
        return $instance;
    }
}

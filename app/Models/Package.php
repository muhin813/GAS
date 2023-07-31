<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];

    public function details()
    {
        $instance = $this->hasMany('App\Models\PackageDetail','package_id','id');
        $instance = $instance->where('status','active');
        return $instance;
    }
    public function benefits()
    {
        $instance = $this->hasMany('App\Models\PackageBenefitFeature','package_id','id');
        $instance = $instance->where('status','active');
        return $instance;
    }
}

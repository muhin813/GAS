<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];

    public function details()
    {
        $instance = $this->hasMany('App\Models\SalesDetail','sales_id','id');
        $instance = $instance->select('sales_details.*','items.name as item_name');
        $instance = $instance->join('items','items.id','sales_details.item_id');
        return $instance;
    }
}

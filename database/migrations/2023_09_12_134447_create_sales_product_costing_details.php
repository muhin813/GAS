<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesProductCostingDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_product_costing_details', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_id');
            $table->integer('item_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('unit_price',10,2)->nullable();
            $table->decimal('total_value',10,2)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_product_costing_details');
    }
}

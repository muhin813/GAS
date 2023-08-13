<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('challan_no')->nullable();
            $table->integer('item_category_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->date('date_of_purchase')->nullable();
            $table->decimal('quantity',10,2)->nullable();
            $table->integer('item_uom_id')->nullable();
            $table->decimal('package',10,2)->nullable();
            $table->integer('package_uom_id')->nullable();
            $table->decimal('unit_price',10,2)->nullable();
            $table->decimal('total_value',10,2)->nullable();
            $table->integer('balance_quantity')->nullable();
            $table->enum('status', ['active','inactive','deleted'])->default('active');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}

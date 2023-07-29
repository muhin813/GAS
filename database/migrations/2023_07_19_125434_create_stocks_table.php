<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_issue')->nullable();
            $table->integer('item_id')->nullable();
            $table->decimal('quantity',10,2)->nullable();
            $table->integer('item_uom_id')->nullable();
            $table->decimal('unit_price',10,2)->nullable();
            $table->decimal('total_value',10,2)->nullable();
            $table->string('supplier_invoice_number')->nullable();
            $table->string('job_tracking_number')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}

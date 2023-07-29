<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->enum('sales_type', ['service','product']);
            $table->integer('booking_id')->nullable();
            $table->string('customer_registration_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('service_amount',10,2)->nullable();
            $table->decimal('discount',10,2)->nullable();
            $table->decimal('vat',10,2)->nullable();
            $table->decimal('total_amount',10,2)->nullable();
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
        Schema::dropIfExists('sales');
    }
}

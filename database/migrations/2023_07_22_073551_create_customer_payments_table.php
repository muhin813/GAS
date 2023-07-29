<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_mode')->nullable();
            $table->date('date_of_sale')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('total_value',10,2)->nullable();
            $table->decimal('paid_amount',10,2)->nullable();
            $table->decimal('due_amount',10,2)->nullable();
            $table->date('payment_date')->nullable();
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
        Schema::dropIfExists('customer_payments');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_payments', function (Blueprint $table) {
            $table->id();
            $table->string('purpose_of_payment')->nullable();
            $table->string('receipt')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('voucher_number')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('other_payments');
    }
}

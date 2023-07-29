<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankReconciliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_reconciliations', function (Blueprint $table) {
            $table->id();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('bank_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->decimal('bank_statement_closing_balance',10,2)->nullable();
            $table->string('outstanding_cheques',256)->nullable();
            $table->decimal('outstanding_cheque_amount',10,2)->nullable();
            $table->json('outstanding_deposits')->nullable();
            $table->decimal('outstanding_deposit_amount',10,2)->nullable();
            $table->json('other_payments')->nullable();
            $table->decimal('other_payment_amount',10,2)->nullable();
            $table->json('other_deposits')->nullable();
            $table->decimal('other_deposit_amount',10,2)->nullable();
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
        Schema::dropIfExists('bank_reconciliations');
    }
}

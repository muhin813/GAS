<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('account_number')->nullable();
            $table->string('party_category')->nullable();
            $table->string('party_name')->nullable();
            $table->string('cheque_book_number')->nullable();
            $table->decimal('cash_in_hand_opening_balance',10,2)->nullable();
            $table->decimal('cash_at_bank_opening_balance',10,2)->nullable();
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
        Schema::dropIfExists('accounts');
    }
}

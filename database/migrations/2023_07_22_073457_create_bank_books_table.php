<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_books', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->nullable();
            $table->integer('bank_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('cheque_book_id')->nullable();
            $table->string('cheque_number')->nullable();
            $table->integer('party',)->nullable();
            $table->string('narration')->nullable();
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
        Schema::dropIfExists('bank_books');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageSubDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_sub_details', function (Blueprint $table) {
            $table->id();
            $table->integer('package_details_id')->nullable();
            $table->string('description')->nullable();
            $table->enum('status', ['active','inactive','deleted'])->default('active');
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
        Schema::dropIfExists('package_sub_details');
    }
}

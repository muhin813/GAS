<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerVehicleCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_vehicle_credentials', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->string('name')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('model')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_vehicle_credentials');
    }
}

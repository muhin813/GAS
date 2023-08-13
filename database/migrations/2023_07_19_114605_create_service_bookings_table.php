<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->string('booking_number')->nullable();
            $table->integer('service_category_id')->nullable();
            $table->integer('service_type_id')->nullable();
            $table->integer('vehicle_credential_id')->nullable();
            $table->timestamp('booking_date')->nullable();
            $table->timestamp('request_completion_date')->nullable();
            $table->text('special_note')->nullable();
            $table->tinyInteger('home_pickup_drop')->nullable()->default(0);
            $table->enum('emergency', ['Yes','No'])->default('No');
            $table->enum('confirmation_status', ['pending','confirmed'])->default('pending');
            $table->date('confirmation_date')->nullable();
            $table->time('confirmation_time')->nullable();
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
        Schema::dropIfExists('service_bookings');
    }
}

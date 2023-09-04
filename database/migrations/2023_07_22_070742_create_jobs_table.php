<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->nullable();
            $table->timestamp('opening_time')->nullable();
            $table->integer('job_category')->nullable();
            $table->integer('job_type')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('customer_vehicle_credential_id')->nullable();
            $table->integer('job_assigned_person_id')->nullable();
            $table->timestamp('job_closing_date')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}

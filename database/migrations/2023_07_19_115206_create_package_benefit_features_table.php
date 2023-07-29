<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageBenefitFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_benefit_features', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id')->nullable();
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
        Schema::dropIfExists('package_benefit_features');
    }
}

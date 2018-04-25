<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('picture')->nullable();
            $table->string('client')->nullable();
            $table->string('agent')->nullable();
            $table->string('agent_username')->nullable();
            $table->string('agent_phone')->nullable();
            $table->string('sales_username')->nullable();
            $table->string('sales_phone')->nullable();
            $table->string('sales_director')->nullable();
            $table->string('regional_manager')->nullable();
            $table->bigInteger('category_id')->default(0);
            $table->bigInteger('model_id')->default(0);
            $table->string('model_remarks')->nullable();
            $table->string('model_temperature')->nullable();
            $table->string('number')->nullable();
            $table->string('embedded_series_number')->nullable();
            $table->string('machine_series_number')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('work_date')->nullable();
            $table->bigInteger('district_id')->default(0);
            $table->bigInteger('province_id')->default(0);
            $table->bigInteger('city_id')->default(0);
            $table->bigInteger('industry_id')->default(0);
            $table->string('industry_remarks')->nullable();
            $table->bigInteger('status_id')->default(0);
            $table->boolean('is_running')->default(false);
            $table->boolean('has_warning')->default(false);
            $table->boolean('need_maintain')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('devices');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->bigInteger('user_category')->default(0);
            $table->bigInteger('district_id')->default(0);
            $table->bigInteger('province_id')->default(0);
            $table->bigInteger('city_id')->default(0);
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

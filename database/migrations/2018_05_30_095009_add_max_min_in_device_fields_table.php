<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaxMinInDeviceFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_fields', function (Blueprint $table) {
            $table->string('max')->nullable();
            $table->string('min')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_fields', function (Blueprint $table) {
            $table->dropColumn('max');
            $table->dropColumn('min');
        });
    }
}

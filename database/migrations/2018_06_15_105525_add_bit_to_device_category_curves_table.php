<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBitToDeviceCategoryCurvesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_category_curves', function (Blueprint $table) {
            $table->integer('bit');
            $table->integer('length')->dafault(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_category_curves', function (Blueprint $table) {
            $table->dropColumn('bit');
            $table->dropColumn('length');
        });
    }
}

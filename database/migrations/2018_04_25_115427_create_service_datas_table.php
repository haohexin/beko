<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('device_id')->default(0)->index();
            $table->string('pressure_dewpoint_temperature')->comment('压力露点温度')->nullable();
            $table->string('control_mode')->comment('控制模式')->nullable();
            $table->string('TIR101_temperature')->comment('TIR101温度')->nullable();
            $table->string('TIR102_temperature')->comment('TIR102温度')->nullable();
            $table->string('PIR101_B1_pressure')->comment('B1塔PIR101压力')->nullable();
            $table->string('PIR102_B2_pressure')->comment('B2塔PIR102压力')->nullable();
            $table->string('B1_status')->comment('B1塔状态')->nullable();
            $table->string('B2_status')->comment('B2塔状态')->nullable();
            $table->string('max_adsorption_time')->comment('露点控制最长吸附时间')->nullable();
            $table->string('time_control_switching_time')->comment('时间控制切换时间')->nullable();
            $table->string('min_regeneration_time')->comment('最短再生时间')->nullable();
            $table->string('min_fan_delay_stop_time')->comment('最小风机延时停止时间')->nullable();
            $table->string('max_fan_delay_stop_time')->comment('最大风机延时停止时间')->nullable();
            $table->string('max_regeneration_time')->comment('最长再生时间')->nullable();
            $table->string('min_cooling_time')->comment('最短冷却时间')->nullable();
            $table->string('max_cooling_time')->comment('最长冷却时间')->nullable();
            $table->string('relief_time')->comment('泄压时间')->nullable();
            $table->string('build_pressure_time')->comment('建压时间')->nullable();
            $table->string('parallel_output_time')->comment('平行输出时间')->nullable();
            $table->string('supplement_cooling_time')->comment('用压缩空气补充冷却时间')->nullable();
            $table->string('stardelta_convert_time')->comment('星三角转换时间')->nullable();
            $table->string('stardelta_contact_time')->comment('星三角接触时间')->nullable();
            $table->string('heater_control_temperature')->comment('加热器控制温度')->nullable();
            $table->string('reproduction_end_temperature')->comment('再生结束温度')->nullable();
            $table->string('cooling_end_temperature')->comment('冷却结束温度')->nullable();
            $table->string('compressedair_cooling_temperature')->comment('压缩空气冷却温度设定')->nullable();
            $table->string('compressedair_cooling2_temperature')->comment('压缩空气二次冷却温度设定')->nullable();
            $table->string('fandelay_stop_temperature')->comment('风机延时停止温度')->nullable();
            $table->string('minimal_working_pressure')->comment('最小操作压力')->nullable();
            $table->string('switch_over_dewpiont')->comment('切换压力露点')->nullable();
            $table->string('alarm_dewpoint')->comment('压力露点报警')->nullable();
            $table->string('dewpoint_for_4mA')->comment('对应露点')->nullable();
            $table->string('dewpoint_for_20mA')->comment('20mA对应露点')->nullable();
            $table->string('heater_overtemperature')->comment('加热器过温')->nullable();
            $table->string('inlet_alarm_temperature')->comment('入口报警温度')->nullable();
            $table->string('heater_delay_on')->comment('延时开启加热器')->nullable();
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
        Schema::dropIfExists('service_datas');
    }
}

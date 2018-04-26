<?php

namespace App\Admin\Controllers;

use App\Models\ControlMode;
use App\Models\Device;
use App\Models\ServiceData;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ServiceDataController extends Controller
{
    use ModelForm;

    public function __construct(Device $device, ControlMode $controlMode)
    {
        $this->devices = $device->pluck('client', 'id');
        $this->controlModes = $controlMode->pluck('title', 'id');
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('运行数据');
            $content->description('所有数据');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('运行数据');
            $content->description('编辑');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('运行数据');
            $content->description('创建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(ServiceData::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('device.client','设备')->label()->sortable();
            $grid->column('pressure_dewpoint_temperature','压力露点温度');
            $grid->column('controlMode.title','控制模式')->label();
            $grid->column('TIR101_temperature','TIR101温度');
            $grid->column('TIR102_temperature','TIR102温度');
            $grid->column('PIR101_B1_pressure','B1塔PIR101压力');
            $grid->column('PIR102_B2_pressure','B2塔PIR102压力');
            $grid->column('B1_status','B1塔状态');
            $grid->column('B2_status','B2塔状态');
            $grid->model()->orderBy('id', 'desc');
            $grid->created_at('创建于');
            $grid->updated_at('修改于');
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->in('device_id', '设备')->multipleSelect($this->devices);
                $filter->in('control_mode', '控制模式')->multipleSelect($this->controlModes);
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ServiceData::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('device_id', '设备')->options($this->devices);
            $form->text('pressure_dewpoint_temperature', '压力露点温度');
            $form->select('control_mode', '控制模式')->options($this->controlModes);
            $form->text('TIR101_temperature', 'TIR101温度');
            $form->text('TIR102_temperature', 'TIR102温度');
            $form->text('PIR101_B1_pressure', 'B1塔PIR101压力');
            $form->text('PIR102_B2_pressure', 'B2塔PIR102压力');
            $form->text('B1_status', 'B1塔状态');
            $form->text('B2_status', 'B2塔状态');
            $form->text('max_adsorption_time', '露点控制最长吸附时间');
            $form->text('time_control_switching_time', '时间控制切换时间');
            $form->text('min_regeneration_time', '最短再生时间');
            $form->text('min_fan_delay_stop_time', '最小风机延时停止时间');
            $form->text('max_fan_delay_stop_time', '最大风机延时停止时间');
            $form->text('max_regeneration_time', '最长再生时间');
            $form->text('min_cooling_time', '最短冷却时间');
            $form->text('max_cooling_time', '最长冷却时间');
            $form->text('relief_time', '泄压时间');
            $form->text('build_pressure_time', '建压时间');
            $form->text('parallel_output_time', '平行输出时间');
            $form->text('supplement_cooling_time', '用压缩空气补充冷却时间');
            $form->text('stardelta_convert_time', '星三角转换时间');
            $form->text('stardelta_contact_time', '星三角接触时间');
            $form->text('heater_control_temperature', '加热器控制温度');
            $form->text('reproduction_end_temperature', '再生结束温度');
            $form->text('cooling_end_temperature', '冷却结束温度');
            $form->text('compressedair_cooling_temperature', '压缩空气冷却温度设定');
            $form->text('compressedair_cooling2_temperature', '压缩空气二次冷却温度设定');
            $form->text('fandelay_stop_temperature', '风机延时停止温度');
            $form->text('minimal_working_pressure', '最小操作压力');
            $form->text('switch_over_dewpiont', '切换压力露点');
            $form->text('alarm_dewpoint', '压力露点报警');
            $form->text('dewpoint_for_4mA', '对应露点');
            $form->text('dewpoint_for_20mA', '20mA对应露点');
            $form->text('heater_overtemperature', '加热器过温');
            $form->text('inlet_alarm_temperature', '入口报警温度');
            $form->text('heater_delay_on', '延时开启加热器');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}

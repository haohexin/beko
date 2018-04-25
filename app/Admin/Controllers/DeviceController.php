<?php

namespace App\Admin\Controllers;

use App\Models\Address;
use App\Models\Device;

use App\Models\DeviceCategory;
use App\Models\DeviceModel;
use App\Models\DeviceStatus;
use App\Models\Industry;
use App\Models\Maintain;
use App\Models\MaintainCategory;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class DeviceController extends Controller
{
    use ModelForm;

    public function __construct(DeviceCategory $deviceCategory, DeviceModel $deviceModel, Address $address, Industry $industry, DeviceStatus $deviceStatus)
    {
        $this->categories = $deviceCategory->pluck('title', 'id');
        $this->models = $deviceModel->pluck('title', 'id');
        $this->addresses = $address->selectOptions();
        $this->industries = $industry->pluck('title', 'id');
        $this->status = $deviceStatus->pluck('title', 'id');
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('设备列表');
            $content->description('所有设备');

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

            $content->header('设备列表');
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

            $content->header('设备列表');
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
        return Admin::grid(Device::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('client','客户名称');
            $grid->column('category.title','类型')->label();
            $grid->column('model.title','类型')->label();
            $grid->column('number','编号');
            $grid->column('delivery_date','出厂时间');
            $grid->column('work_date','开机时间');
            $grid->column('industry.title','行业')->label();
            $grid->column('district.title', '一级区域')->sortable()->label();
            $grid->column('province.title', '二级区域')->sortable()->label();
            $grid->column('city.title', '三级区域')->sortable()->label();
            $grid->column('status.title','状态')->label();
            $grid->is_running('运行中')->display(function ($is_running) {
                return $is_running == '1' ? "<i class='fa fa-check' style='color:green'></i>" : "<i class='fa fa-close' style='color:red'></i>";
            });
            $grid->has_warning('存在报警')->display(function ($has_warning) {
                return $has_warning == '1' ? "<i class='fa fa-check' style='color:green'></i>" : "<i class='fa fa-close' style='color:red'></i>";
            });
            $grid->need_maintain('需要保养')->display(function ($need_maintain) {
                return $need_maintain == '1' ? "<i class='fa fa-check' style='color:green'></i>" : "<i class='fa fa-close' style='color:red'></i>";
            });
            $grid->model()->orderBy('id', 'desc');
            $grid->created_at('创建于');
            $grid->updated_at('修改于');
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->where(function ($query) {
                    $query->where('client', 'like', "%{$this->input}%")
                        ->orWhere('number', 'like', "%{$this->input}%")
                        ->orWhere('agent', 'like', "%{$this->input}%");
                }, '关键词');
                $filter->in('category_id', '类型')->multipleSelect($this->categories);
                $filter->in('model_id', '型号')->multipleSelect($this->models);
                $filter->in('industry_id', '行业')->multipleSelect($this->industries);
                $filter->in('status_id', '设备状态')->multipleSelect($this->status);
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
        return Admin::form(Device::class, function (Form $form) {

            $form->tab('基本信息', function ($form) {

                $form->display('id', 'ID');
                $form->text('client', '客户名称');
                $form->select('category_id', '类型')->options($this->categories);
                $form->select('model_id', '型号')->options($this->models);
                $form->text('model_remarks', '型号补全');
                $form->text('model_temperature', '型号温度');
                $form->text('number', '编号');
                $form->text('embedded_series_number', '嵌入式序列号');
                $form->text('machine_series_number', '机器序列号');
                $form->date('delivery_date', '出厂时间');
                $form->date('work_date', '开机时间');
                $form->select('industry_id', '行业')->options($this->industries);
                $form->text('industry_remarks', '行业备注');
                $form->select('status_id', '设备状态')->options($this->status);
                $form->display('created_at', 'Created At');
                $form->display('updated_at', 'Updated At');

            })->tab('代理商', function ($form) {

                $form->text('agent', '代理商');
                $form->text('agent_username', '代理商联系人');
                $form->mobile('agent_phone', '代理商联系人电话');

            })->tab('销售', function ($form) {
                $form->text('sales_username', '销售联系人');
                $form->mobile('sales_phone', '销售联系人电话');
                $form->text('sales_director', '销售总监');
                $form->text('regional_manager', '销售区域经理');

            })->tab('地址', function ($form) {
                $form->select('district_id', '一级区域')->options($this->addresses);
                $form->select('province_id', '二级区域')->options($this->addresses);
                $form->select('city_id', '三级区域')->options($this->addresses);

            })->tab('报警绑定电话', function ($form) {
                $form->hasMany('warningphones', '报警绑定电话', function ($form) {
                    $form->mobile('phone', '电话号码');
                });

            })->tab('保养绑定电话', function ($form) {
                $form->hasMany('maintainphones', '保养绑定电话', function ($form) {
                    $form->mobile('phone', '电话号码');
                });

            })->tab('保养项', function ($form) {
                $maintainCategory = MaintainCategory::get()->pluck('title', 'id');
                $form->hasMany('maintains', '保养细项', function ($form) use ($maintainCategory) {
                    $form->select('category_id', '保养类型')->options($maintainCategory);
                    $form->number('early_time', '提示天数');
                });

            })->tab('状态', function ($form) {

                $form->switch('is_running', '运行中');
                $form->switch('has_warning', '存在报警');
                $form->switch('need_maintain', '需要保养');
            });

        });
    }
}

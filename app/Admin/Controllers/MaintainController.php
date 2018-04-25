<?php

namespace App\Admin\Controllers;

use App\Models\Device;
use App\Models\Maintain;

use App\Models\MaintainCategory;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class MaintainController extends Controller
{
    use ModelForm;

    public function __construct(Device $device, MaintainCategory $maintainCategory)
    {
        $this->devices = $device->pluck('client', 'id');
        $this->maintainCategories = $maintainCategory->pluck('title','id');
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('保养信息');
            $content->description('所有信息');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('保养信息');
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

            $content->header('保养信息');
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
        return Admin::grid(Maintain::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('device.client','设备')->label();
            $grid->column('category.title','保养类型')->label();
            $grid->column('early_time','提示天数')->label();
            $grid->model()->orderBy('id', 'desc');
            $grid->created_at('创建于');
            $grid->updated_at('修改于');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Maintain::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('device_id', '设备')->options($this->devices);
            $form->select('category_id', '保养类型')->options($this->maintainCategories);
            $form->number('early_time', '提示天数');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}

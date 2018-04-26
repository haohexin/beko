<?php

namespace App\Admin\Controllers;

use App\Models\Device;
use App\Models\Warning;

use App\Models\WarningCategory;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class WarningController extends Controller
{
    use ModelForm;

    public function __construct(Device $device, WarningCategory $warningCategory)
    {
        $this->devices = $device->pluck('client', 'id');
        $this->warningCategories = $warningCategory->pluck('title', 'id');
    }


    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('报警信息');
            $content->description('所有报警');

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

            $content->header('报警信息');
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

            $content->header('报警信息');
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
        return Admin::grid(Warning::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('device.client', '设备')->label();
            $grid->column('category.title', '报警类型')->label();
            $grid->all_clear('清除?')->display(function ($all_clear) {
                return $all_clear == '1' ? "<i class='fa fa-check' style='color:green'></i>" : "<i class='fa fa-close' style='color:red'></i>";
            });
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
        return Admin::form(Warning::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('device_id', '设备')->options($this->devices);
            $form->select('category_id', '报警类型')->options($this->warningCategories);
            $form->switch('all_clear', '清除?');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}

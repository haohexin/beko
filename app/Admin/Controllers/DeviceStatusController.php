<?php

namespace App\Admin\Controllers;

use App\Models\DeviceStatus;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class DeviceStatusController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('设备状态');
            $content->description('所有状态');

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

            $content->header('设备状态');
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

            $content->header('设备状态');
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
        return Admin::grid(DeviceStatus::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('title', '状态')->editable();
            $grid->column('status_code', '状态码')->editable();
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(DeviceStatus::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title', '状态');
            $form->text('status_code', '状态码');
            $form->image('path', '图片');
        });
    }
}

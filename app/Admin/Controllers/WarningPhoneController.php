<?php

namespace App\Admin\Controllers;

use App\Models\Device;
use App\Models\WarningPhone;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class WarningPhoneController extends Controller
{
    use ModelForm;

    public function __construct(Device $device)
    {
        $this->devices = $device->pluck('client', 'id');
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('报警关联手机');
            $content->description('所有信息');

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

            $content->header('报警关联手机');
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

            $content->header('报警关联手机');
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
        return Admin::grid(WarningPhone::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('phone', '手机号码');
            $grid->column('device.client','设备');
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
        return Admin::form(WarningPhone::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('device_id', '设备')->options($this->devices);
            $form->mobile('phone');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}

<?php

namespace App\Admin\Controllers;

use App\Models\DeviceCategory;
use App\Models\DeviceCategoryCurve;

use App\Models\DeviceField;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class DeviceCategoryCurveController extends Controller
{
    use ModelForm;

    public function __construct(DeviceCategory $deviceCategory, DeviceField $deviceField)
    {
        $this->categories = $deviceCategory->pluck('title', 'id');
        $this->fields = $deviceField->pluck('title', 'id');
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('设备类型曲线');
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

            $content->header('设备类型曲线');
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

            $content->header('设备类型曲线');
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
        return Admin::grid(DeviceCategoryCurve::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('category.title', '设备类型')->sortable();
            $grid->column('field.title', '主要字段')->sortable();

            $grid->model()->orderBy('id', 'desc');
            $grid->created_at('创建于');
            $grid->updated_at('修改于');
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->in('category_id', '设备类型')->multipleSelect($this->categories);
                $filter->in('field_id', '主要字段')->multipleSelect($this->fields);
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
        return Admin::form(DeviceCategoryCurve::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('category_id', '设备类型')->options($this->categories);
            $form->select('field_id', '主要字段')->options($this->fields);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}

<?php

namespace App\Admin\Controllers;

use App\Models\Address;
use App\Models\User;

use App\Models\UserCategory;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserController extends Controller
{
    use ModelForm;

    public function __construct(UserCategory $userCategory, Address $address)
    {
        $this->categories = $userCategory->pluck('title', 'id');
        $this->addresses = $address->selectOptions();
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('客户管理');
            $content->description('所有客户');

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

            $content->header('客户管理');
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

            $content->header('客户管理');
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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('category.title', '类型')->sortable()->label();
            $grid->column('username', '用户名');
            $grid->column('name', '真实姓名')->editable();
            $grid->column('phone', '手机号码')->editable();
            $grid->column('company', '所属公司')->editable();
            $grid->column('position', '职位')->editable();
            $grid->column('district.title', '一级区域')->sortable()->label();
            $grid->column('province.title', '二级区域')->sortable()->label();
            $grid->column('city.title', '三级区域')->sortable()->label();
            $grid->model()->orderBy('id', 'desc');
            $grid->created_at('创建于');
            $grid->updated_at('修改于');
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->where(function ($query) {
                    $query->where('name', 'like', "%{$this->input}%")
                        ->orWhere('username', 'like', "%{$this->input}%")
                        ->orWhere('phone', 'like', "%{$this->input}%");
                }, '姓名或电话');
                $filter->in('user_category', '类型')->multipleSelect($this->categories);
                $filter->in('district_id', '一级区域')->multipleSelect($this->addresses);
                $filter->in('province_id', '二级区域')->multipleSelect($this->addresses);
                $filter->in('city_id', '三级区域')->multipleSelect($this->addresses);
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
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('user_category', '类型')->options($this->categories);
            $form->text('username', '用户名');
            $form->password('password', '密码')->rules('confirmed');
            $form->password('password_confirmation', '重复密码');
            $form->select('district_id', '一级区域')->options($this->addresses);
            $form->select('province_id', '二级区域')->options($this->addresses);
            $form->select('city_id', '三级区域')->options($this->addresses);
            $form->mobile('phone', '手机号码');
            $form->text('name', '真实姓名');
            $form->text('company', '所属公司');
            $form->text('position', '职位');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
            $form->ignore(['password_confirmation']);

            $form->saving(function (Form $form) {
                $form->password = bcrypt($form->password);
            });
        });
    }
}

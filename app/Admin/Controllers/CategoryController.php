<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分类管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category);

        $grid->model()->orderBy('rank', 'asc');

        $grid->column('id', __('Id'));
        $grid->column('category_name', __('Category name'));
        $grid->column('status', __('Status'))->switch([
            'on'  => ['value' => Category::ONLINE, 'text' => '正常', 'color' => 'primary'],
            'off' => ['value' => Category::OFFLINE, 'text' => '关闭', 'color' => 'default'],
        ]);
        $grid->column('can_register', __('Can register'))->switch([
            'on'  => ['value' => Category::CAN_REGISTER, 'text' => '可申请', 'color' => 'primary'],
            'off' => ['value' => Category::CANNOT_REGISTER, 'text' => '关闭', 'color' => 'default'],
        ]);;
        $grid->column('rank', __('Rank'))->sortableColumn(Category::class);;
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category_name', __('Category name'));
        $show->field('status', __('Status'));
        $show->field('can_register', __('Can register'));
        $show->field('rank', __('Rank'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category);

        $form->text('category_name', __('Category name'));
        $form->number('status', __('Status'))->default(1);
        $form->number('can_register', __('Can register'))->default(1);
        $form->number('rank', __('Rank'));

        return $form;
    }
}

<?php

namespace App\Admin\Controllers;

use App\Models\Link;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LinkController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '友链管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Link);

        $grid->model()->orderBy('rank', 'asc');

        $grid->paginate(200);

        $grid->column('id', __('Id'))->sortable();
        $grid->column('web_name', __('Web name'));
        $grid->column('link', __('Link'));
        $grid->column('top_domain', __('Top domain'));
        $grid->column('domain_name', __('Domain name'));
        $grid->column('category.category_name', __('Category name'));
        $grid->column('status', __('Status'))->editable('select', Link::$statusMap);
        $grid->column('view', __('View'))->sortable();
        $grid->column('ip', __('Ip'));
        $grid->column('failure_times', __('Failure times'));
        $grid->column('type', __('Type'));
        $grid->column('rank', __('Rank'))->sortableColumn(Link::class);
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('web_name', __('Web name'));

        });

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
        $show = new Show(Link::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('web_name', __('Web name'));
        $show->field('link', __('Link'));
        $show->field('top_domain', __('Top domain'));
        $show->field('domain_name', __('Domain name'));
        $show->field('category_id', __('Category id'));
        $show->field('status', __('Status'));
        $show->field('view', __('View'));
        $show->field('ip', __('Ip'));
        $show->field('failure_times', __('Failure times'));
        $show->field('type', __('Type'));
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
        $form = new Form(new Link);

        $form->text('web_name', __('Web name'));
        $form->url('link', __('Link'));
        $form->text('top_domain', __('Top domain'));
        $form->text('domain_name', __('Domain name'));
        $form->number('category_id', __('Category id'));
        $form->switch('status', __('Status'));
        $form->number('view', __('View'));
        $form->ip('ip', __('Ip'));
        $form->switch('failure_times', __('Failure times'));
        $form->text('type', __('Type'));
        $form->number('rank', __('Rank'));

        return $form;
    }
}

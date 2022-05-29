<?php

namespace App\Admin\Controllers;

use App\Models\BrandType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BrandTypeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = \App\Models\BrandType::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BrandType());

        $grid->name()->sortable()->editable();
        $grid->slug()->sortable()->editable();
        $grid->text()->display(function ($value) {
            return str_split(htmlspecialchars($value), 100)[0].' [...]';
        });
        $grid->created_at()->sortable();
        $grid->updated_at()->sortable();

        $grid->sortable();

        $grid->filter(function ($filter) {
            $filter->ilike('name');
            $filter->ilike('slug');
        });

        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('name', __('Name'));
        });

        $grid->quickSearch('name');

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
        $show = new Show(BrandType::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('slug', __('Slug'));
        $show->field('text', __('Text'));
        $show->field('order_column', __('Order Column'));
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
        $form = new Form(new BrandType());

        $form->text('name', __('Name'));
        $form->text('slug', __('Slug'));
        $form->ckeditor('text', __('Text'));

        return $form;
    }
}

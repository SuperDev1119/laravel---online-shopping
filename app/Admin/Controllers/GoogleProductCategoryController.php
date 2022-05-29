<?php

namespace App\Admin\Controllers;

use App\Models\GoogleProductCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GoogleProductCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = \App\Models\GoogleProductCategory::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GoogleProductCategory);

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('created_at', __('Created at'))->sortable()->hide();
        $grid->column('updated_at', __('Updated at'))->sortable()->hide();

        $grid->filter(function ($filter) {
            $filter->ilike('name');
        });

        $grid->quickSearch('name');

        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->disableActions();

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
        $show = new Show(GoogleProductCategory::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
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
        $form = new Form(new GoogleProductCategory);

        $form->number('id', __('Id'));
        $form->textarea('name', __('Name'));

        return $form;
    }
}

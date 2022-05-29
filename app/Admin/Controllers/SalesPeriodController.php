<?php

namespace App\Admin\Controllers;

use App\Models\SalesPeriod;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SalesPeriodController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = \App\Models\SalesPeriod::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SalesPeriod());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'))->editable();
        $grid->column('is_active')->display(function() {
            return $this->is_active();
        })->bool();
        $grid->column('starts_at', __('Starts at'))->editable();
        $grid->column('ends_at', __('Ends at'))->editable();
        $grid->column('created_at', __('Created at'))->hide();
        $grid->column('updated_at', __('Updated at'))->hide();

        $grid->model()->orderBy('updated_at', 'desc');

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
        $show = new Show(SalesPeriod::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('starts_at', __('Starts at'));
        $show->field('ends_at', __('Ends at'));
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
        $form = new Form(new SalesPeriod());

        $form->text('name', __('Name'));
        $form->datetime('starts_at', __('Starts at'))->default(date('Y-m-d H:i:s'));
        $form->datetime('ends_at', __('Ends at'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}

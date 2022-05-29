<?php

namespace App\Admin\Controllers;

use App\Models\FaqItem;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FaqItemController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = \App\Models\FaqItem::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FaqItem);

        $grid->column('id', __('Id'))->sortable();
        $grid->column('question', __('Question'))->sortable()->editable();
        $grid->column('answer', __('Answer'))->display(function ($value) {
            return str_split(htmlspecialchars($value), 75)[0].' [...]';
        })->sortable();
        $grid->column('order', __('Order'))->sortable();
        $grid->column('created_at', __('Created at'))->sortable()->hide();
        $grid->column('updated_at', __('Updated at'))->sortable()->hide();

        $grid->filter(function ($filter) {
            $filter->ilike('question');
            $filter->ilike('answer');
        });

        $grid->sortable();

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
        $show = new Show(FaqItem::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('question', __('Question'));
        $show->field('answer', __('Answer'));
        $show->field('order', __('Order'));
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
        $form = new Form(new FaqItem);

        $form->textarea('question', __('Question'));
        $form->ckeditor('answer', __('Answer'));

        return $form;
    }
}

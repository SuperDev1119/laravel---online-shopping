<?php

namespace App\Admin\Controllers;

use App\Models\PushLinking;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PushLinkingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = PushLinking::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PushLinking);

        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('Title'))->sortable()->editable();
        $grid->column('link', __('Link'))->sortable();
        $grid->column('order_column', __('Order Column'))->sortable();
        $grid->column('created_at', __('Created at'))->sortable()->hide();
        $grid->column('updated_at', __('Updated at'))->sortable()->hide();

        $grid->filter(function ($filter) {
            $filter->ilike('link');
            $filter->ilike('title');
        });

        $grid->sortable();

        $grid->quickSearch('title');

        $grid->paginate(100);

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
        $show = new Show(PushLinking::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('link', __('Link'))->link();
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
        $form = new Form(new PushLinking);

        $form->text('title', __('Title'));
        $form->url('link', __('Link'));

        return $form;
    }
}

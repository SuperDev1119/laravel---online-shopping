<?php

namespace App\Admin\Controllers;

use App\Models\Gender;
use App\Models\MenuPanel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MenuPanelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = MenuPanel::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MenuPanel);

        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('Title'))->sortable()->editable();
        $grid->column('url', __('Url'))->sortable()->editable();
        $grid->column('gender', __('Gender'))->sortable()->editable('select', array_flip(Gender::genders()));
        $grid->column('category', __('Category'))->sortable();
        $grid->column('background', __('Background'))->sortable()->editable('textarea');
        $grid->column('order', __('Order'))->sortable();
        $grid->column('created_at', __('Created at'))->sortable()->hide();
        $grid->column('updated_at', __('Updated at'))->sortable()->hide();

        $grid->filter(function ($filter) {
            $filter->equal('gender')->select(array_combine(Gender::genders(), Gender::genders()));
            $filter->ilike('category');
            $filter->ilike('background');
            $filter->ilike('url');
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
        $show = new Show(MenuPanel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('gender', __('Gender'));
        $show->field('category', __('Category'));
        $show->field('background', __('Background'));
        $show->field('url', __('Url'));
        $show->field('title', __('Title'));
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
        $form = new Form(new MenuPanel);

        $form->select('gender')->options(array_flip(Gender::genders()))->default(Gender::GENDER_BOTH);
        $form->text('category', __('Category'));
        $form->url('background', __('Background'));
        $form->text('url', __('Url'));
        $form->text('title', __('Title'));
        $form->number('order', __('Order'));

        return $form;
    }
}

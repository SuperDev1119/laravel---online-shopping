<?php

namespace App\Admin\Controllers;

use App\Models\Color;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ColorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = Color::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Color);

        $grid->id()->sortable();
        $grid->name()->sortable()->editable();

        $grid->created_at()->sortable()->hide();
        $grid->updated_at()->sortable()->hide();

        $grid->filter(function ($filter) {
            $filter->ilike('name');
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
        $show = new Show(Color::findOrFail($id));

        $show->id();
        $show->name();

        $show->created_at();
        $show->updated_at();

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Color);

        $form->text('name');

        $form->display('created_at');
        $form->display('updated_at');

        return $form;
    }
}

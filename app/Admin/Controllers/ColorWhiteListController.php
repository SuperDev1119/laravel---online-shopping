<?php

namespace App\Admin\Controllers;

use App\Models\ColorWhiteList;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ColorWhiteListController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = ColorWhiteList::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ColorWhiteList);

        $grid->white_list_id()->sortable();
        $grid->color()->name()->label()->sortable();
        $grid->amount()->sortable();
        $grid->created_at()->sortable();
        $grid->updated_at()->sortable();

        $grid->filter(function ($filter) {
            $filter->equal('white_list_id');
            $filter->equal('color_id');
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
        $show = new Show(ColorWhiteList::findOrFail($id));

        $show->white_list_id();
        $show->color_id();
        $show->amount();
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
        $form = new Form(new ColorWhiteList);

        $form->number('white_list_id');
        $form->number('color_id');

        return $form;
    }
}

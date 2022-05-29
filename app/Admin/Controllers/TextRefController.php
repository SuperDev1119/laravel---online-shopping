<?php

namespace App\Admin\Controllers;

use App\Models\TextRef;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TextRefController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = TextRef::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TextRef);

        $grid->id()->sortable();
        $grid->url()->sortable()->editable();
        $grid->text()->display(function ($value) {
            return str_split(htmlentities($value), 100)[0].' [...]';
        });
        $grid->created_at()->sortable()->hide();
        $grid->updated_at()->sortable()->hide();

        $grid->filter(function ($filter) {
            $filter->ilike('url');
            $filter->ilike('text');
        });

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
        $show = new Show(TextRef::findOrFail($id));

        $show->id();
        $show->url();
        $show->text();
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
        $form = new Form(new TextRef);

        $form->text('url');
        $form->ckeditor('text');

        return $form;
    }
}

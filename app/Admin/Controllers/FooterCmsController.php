<?php

namespace App\Admin\Controllers;

use App\Models\FooterCms;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FooterCmsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = FooterCms::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FooterCms);

        $grid->id()->sortable();
        $grid->url()->sortable()->editable();
        $grid->title()->sortable()->editable();
        $grid->content()->display(function ($value) {
            return str_split(htmlspecialchars($value), 100)[0].' [...]';
        });
        $grid->created_at()->sortable()->hide();
        $grid->updated_at()->sortable()->hide();

        $grid->filter(function ($filter) {
            $filter->ilike('url');
            $filter->ilike('title');
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
        $show = new Show(FooterCms::findOrFail($id));

        $show->id();
        $show->url();
        $show->title();
        $show->content();
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
        $form = new Form(new FooterCms);

        $form->text('url');
        $form->text('title');
        $form->ckeditor('content');

        return $form;
    }
}

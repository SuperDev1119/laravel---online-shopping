<?php

namespace App\Admin\Controllers;

use App\Models\ImportTask;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ImportTaskController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = ImportTask::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ImportTask);

        $grid->id()->sortable();
        $grid->finished()->bool()->sortable();
        $grid->created_at()->sortable();
        $grid->updated_at()->sortable();

        $grid->filter(function ($filter) {
            $filter->equal('finished')->radio([
                __('NON'),
                __('OUI'),
            ]);
        });

        $grid->model()->orderBy('updated_at', 'desc');

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
        $show = new Show(ImportTask::findOrFail($id));

        $show->id();
        $show->finished();
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
        $form = new Form(new ImportTask);

        return $form;
    }
}

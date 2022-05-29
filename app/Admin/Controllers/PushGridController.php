<?php

namespace App\Admin\Controllers;

use App\Models\PushGrid;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PushGridController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = \App\Models\PushGrid::class;

    private $fn_video;

    public function __construct()
    {
        $this->fn_video = function ($v) {
            $attrs = 'style="max-width:200px;max-height:200px" class="img img-thumbnail"';

            return (false === strpos($v, 'mp4')) ?
            '<img src="'.$v.'" '.$attrs.'>' :
    '<video autoplay muted loop playsinline '.$attrs.'>
      <source src="'.$v.'" type="video/mp4">
    </video>';
        };
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PushGrid);

        $grid->column('id', __('Id'))->sortable();
        $grid->column('url', __('Url'))->display($this->fn_video);
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->filter(function ($filter) {
            $filter->ilike('url');
        });

        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('url', __('Url'));
        });

        $grid->quickSearch('url');

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
        $show = new Show(PushGrid::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('url', __('Url'))->unescape()->as($this->fn_video);
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
        $form = new Form(new PushGrid);

        $form->url('url', __('Url'));

        return $form;
    }
}

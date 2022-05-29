<?php

namespace App\Admin\Controllers;

use App\Models\Brand;
use App\Models\BrandType;
use App\Models\Gender;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BrandController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = Brand::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Brand);

        $grid->name()->sortable();
        $grid->display_name()->sortable()->editable();
        $grid->slug()->sortable();
        $grid->gender()->sortable()->editable('select', array_flip(Gender::genders()));
        $grid->in_listing()->sortable()->switch();
        $grid->is_top()->sortable()->switch();
        $grid->brand_type_id()->sortable()->editable('select', BrandType::all()->pluck('name', 'id'));
        $grid->created_at()->sortable();
        $grid->updated_at()->sortable();

        $grid->filter(function ($filter) {
            $filter->equal('gender')->select(array_combine(Gender::genders(), Gender::genders()));
            $filter->equal('brand_type_id')->select(BrandType::all()->pluck('name', 'id'));
            $filter->ilike('name');
            $filter->ilike('display_name');
            $filter->ilike('slug');
            $filter->equal('in_listing')->radio([
                __('NON'),
                __('OUI'),
            ]);
            $filter->equal('is_top')->radio([
                __('NON'),
                __('OUI'),
            ]);
        });

        $grid->quickSearch('name');

        $grid->paginate(50);

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
        $show = new Show(Brand::findOrFail($id));

        $show->id();
        $show->name();
        $show->display_name();
        $show->slug();
        $show->gender();
        $show->in_listing();
        $show->is_top();
        $show->brand_type_id();
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
        $form = new Form(new Brand);

        $form->text('name');
        $form->text('display_name');
        $form->text('slug');
        $form->select('gender')->options(array_flip(Gender::genders()))->default(Gender::GENDER_BOTH);
        $form->switch('in_listing');
        $form->switch('is_top');
        $form->select('brand_type_id')->options(BrandType::all()->pluck('name', 'id'));

        return $form;
    }
}

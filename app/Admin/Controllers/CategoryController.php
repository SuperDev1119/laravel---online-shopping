<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Gender;
use App\Models\GoogleProductCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = Category::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category);

        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('Title'))->sortable()->editable();
        $grid->column('query', __('Query'))->sortable()->editable();
        $grid->column('slug', __('Slug'))->sortable()->editable();
        $grid->column('gender', __('Gender'))->sortable()->editable('select', array_flip(Gender::genders()));
        $grid->column('depth', __('Depth'))->sortable();
        $grid->column('parent_id', __('Parent (slug)'))->display(function ($v) {
            return $v ? Category::find($v)->slug : null;
        })->sortable();
        $grid->column('google_product_category_id', __('Google Category (ID)'))->sortable();
        $grid->column('google_product_category.name', __('Google Category (Name)'));
        $grid->column('created_at', __('Created at'))->sortable()->hide();
        $grid->column('updated_at', __('Updated at'))->sortable()->hide();

        $grid->filter(function ($filter) {
            $filter->ilike('title');
            $filter->ilike('slug');
            $filter->equal('gender')->select(array_combine(Gender::genders(), Gender::genders()));
            $filter->equal('depth');
        });

        $grid->quickSearch('title');

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
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('query', __('Query'));
        $show->field('slug', __('Slug'));
        $show->field('gender', __('Gender'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('_lft', __(' lft'));
        $show->field('_rgt', __(' rgt'));
        $show->field('depth', __('Depth'));
        $show->field('parent_id', __('Parent (ID)'));

        $show->field('google_product_category_id', __('Google Product Category (ID)'));
        $show->field('google_product_category_name', __('Google Product Category (Name)'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category);

        $form->text('title', __('Title'));
        $form->text('query', __('Query'));
        $form->text('slug', __('Slug'));
        $form->select('gender')->options(array_flip(Gender::genders()))->default(Gender::GENDER_BOTH);

        $form->select('parent_id')->options(function ($id) {
            if ($category = Category::find($id)) {
                return [$category->id => $category->title];
            }
        })->ajax('/'.config('admin.route.prefix').'/api/categories');

        $form->select('google_product_category_id')->options(function ($id) {
            if ($google_product_category = GoogleProductCategory::find($id)) {
                return [$google_product_category->id => $google_product_category->name];
            }
        })->ajax('/'.config('admin.route.prefix').'/api/google_product_categories');

        return $form;
    }
}

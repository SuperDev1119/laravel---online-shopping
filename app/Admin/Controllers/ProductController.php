<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = Product::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);

        $grid->i();
        $grid->name();
        $grid->slug();
        // $grid->description();
        $grid->brand_original('Brand');
        // $grid->merchant_original('Merchant');
        $grid->category_original('Category');
        $grid->color_original()->hide();
        $grid->currency_original()->hide();
        $grid->price()->hide();
        $grid->old_price()->hide();
        $grid->reduction()->hide();
        // $grid->url();
        // $grid->image_url();
        $grid->gender();
        $grid->provider()->hide();
        // $grid->col();
        // $grid->coupe();
        // $grid->manches();
        // $grid->material();
        // $grid->model();
        // $grid->motifs();
        // $grid->event();
        // $grid->style();
        // $grid->size();
        // $grid->livraison();
        // $grid->payload();

        $grid->quickSearch('slug');

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
        $show = new Show(Product::findOrFail($id));

        $show->i();
        $show->name();
        $show->slug();
        $show->description();
        $show->brand_original();
        $show->merchant_original();
        $show->category_original();
        $show->color_original();
        $show->currency_original();
        $show->price();
        $show->old_price();
        $show->reduction();
        $show->url();
        $show->image_url();
        $show->gender();
        $show->provider();
        $show->col();
        $show->coupe();
        $show->manches();
        $show->material();
        $show->model();
        $show->motifs();
        $show->event();
        $show->style();
        $show->size();
        $show->livraison();
        $show->payload();

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product);

        $form->text('name');
        $form->text('slug');
        $form->textarea('description');
        $form->text('brand_original');
        $form->text('merchant_original');
        $form->text('category_original');
        $form->text('color_original');
        $form->text('currency_original');
        $form->decimal('price');
        $form->decimal('old_price');
        $form->number('reduction');
        $form->textarea('url');
        $form->textarea('image_url');
        $form->text('gender');
        $form->text('provider');
        $form->textarea('col');
        $form->textarea('coupe');
        $form->textarea('manches');
        $form->textarea('material');
        $form->textarea('model');
        $form->textarea('motifs');
        $form->textarea('event');
        $form->textarea('style');
        $form->textarea('size');
        $form->textarea('livraison');
        $form->textarea('payload');

        return $form;
    }
}

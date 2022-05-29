<?php

namespace App\Admin\Controllers;

use App\Models\Gender;
use App\Models\Source;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SourceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = Source::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Source);

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('title', __('Title'))->sortable();
        $grid->column('parser', __('Parser'))->label()->sortable();
        $grid->column('config')->display(function ($value) {
            return (empty($value) || empty(array_values(array_filter($value)))) ? false : count($value);
        })->label('warning');
        $grid->column('enabled', __('Enabled'))->sortable()->switch();
        $grid->column('language', __('Language'))->sortable();
        $grid->column('priority', __('Priority'))->sortable();
        $grid->column('nb_of_products', __('#'))->sortable();
        $grid->column('extra', __('Extra'))->display(function ($value) {
            return str_split($value, 50)[0].' [...]';
        })->sortable()->hide();
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->filter(function ($filter) {
            $parser = \App\Console\Commands\UpdateSources::$all_providers;

            $filter->ilike('name');
            $filter->ilike('title');
            $filter->ilike('path');
            $filter->ilike('language');
            $filter->ilike('extra');
            $filter->equal('parser')->select(array_combine($parser, $parser));
            $filter->equal('enabled')->radio([
                __('NON'),
                __('OUI'),
            ]);
        });

        $grid->sortable();

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
        $show = new Show(Source::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('title');
        $show->field('parser', __('Parser'));
        $show->field('path', __('Path'))->link();
        $show->field('enabled', __('Enabled'));
        $show->field('language', __('Language'));
        $show->field('priority', __('Priority'));
        $show->field('nb_of_products', __('Nb of products'));
        $show->field('config', __('Config'))->json();
        $show->field('extra', __('Extra'))->unescape()->as($this->fn_display_raw_array);
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    private $fn_display_raw_array;

    public function __construct()
    {
        $this->fn_display_raw_array = function ($v) {
            return '<pre>'.print_r($v, true).'</pre>';
        };
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Source);

        $model = $form->model();

        $form->text('name', __('Name'));
        $form->text('title');
        $form->text('parser', __('Parser'));
        $form->textarea('path', __('Path'));
        $form->switch('enabled', __('Enabled'));
        $form->text('language', __('Language'));
        $form->text('priority');
        // $form->textarea('extra', __('Extra'));
        $form->embeds('config', function ($form) use ($model) {
            $form->select(Source::CONFIG_FIX_UTF8)->options([
                false => 'NON',
                true => 'OUI',
            ]);

            $form->select(Source::CONFIG_COL_SEPARATOR)->options([
                ','  => 'COMMA (,)',
                ';'  => 'SEMICOLON (;)',
                '|'  => 'PIPE (|)',
                "\t" => 'TAB (\t)',
            ]);
            $form->text(Source::CONFIG_CSV_HEADERS);
            $form->text(Source::CONFIG_XML_UNIQUENODE);
            $form->text(Source::CONFIG_XML_NAMESPACE);
            $form->number(Source::CONFIG_TIMEOUT);
            $form->text(Source::CONFIG_FORCE_BRAND_NAME);
            $form->select(Source::CONFIG_FORCE_GENDER)->options(array_flip(Gender::genders()));
            $form->text(Source::CONFIG_APPEND_CATEGORY);
            $form->text(Source::CONFIG_TRANSFORM_URL);
            $form->textarea(Source::CONFIG_STR_REPLACE_IMAGE);

            $form->text(Source::CONFIG_CONVERT_CURRENCY_FROM);

            $form->text(Source::CONFIG_PRESTASHOP_LANGUAGE);
            $form->number(Source::CONFIG_PRESTASHOP_LANGUAGE_ID);
            $form->text(Source::CONFIG_PRESTASHOP_IMAGE_TYPE);
        });

        return $form;
    }
}

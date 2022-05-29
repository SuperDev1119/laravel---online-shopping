<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\DataFromGoogle;
use App\Models\Gender;
use App\Models\ModelFromGoogle;
use DB;
use Illuminate\Console\Command;

class CategoryFromGoogle extends ModelFromGoogle
{
    const CACHING_TIME_ALL = 21600; // 60*24*15 ( 15 days )

    public $slug = null;

    public $title = null;

    public $gender = Gender::GENDER_BOTH;

    public $children = [];

    public $parent = null;

    public $_parent = null;

    public $_gender = null;

    protected static $fields = [
        'title',
        'slug',
        'gender',
    ];

    public function __construct($values = [])
    {
        parent::__construct($values);

        if (! empty($values['parent'])) {
            $this->_parent = $values['parent'];
        }
    }

    public function __toString()
    {
        return $this->title;
    }

    public function addChild($child)
    {
        if (! in_array($child, $this->children)) {
            $child->parent = $this;
            $this->children[] = $child;
        }

        return $this;
    }

    public static function buildFromArray($categories_as_array)
    {
        $categories_as_objects = [];
        $categories_as_objects['roots'] = [];

        if (
      empty($categories_as_array)
      || ! is_array($categories_as_array)
      ) {
            return $categories_as_objects;
        }

        foreach ($categories_as_array as $values) {
            $category = new static($values);
            $categories_as_objects[$category->slug] = $category;
        }

        foreach ($categories_as_objects as $slug => $category) {
            if ('roots' === $slug) {
                continue;
            }

            if (empty($category->_parent)) {
                $categories_as_objects['roots'][] = $category;
            }

            if (isset($categories_as_objects[$category->_parent])) {
                $categories_as_objects[$category->_parent]->addChild($category);
            }
        }

        return $categories_as_objects;
    }

    public static function all($flatten = false)
    {
        $categories = DataFromGoogle::csv(env('URL_GOOGLE_CSV_CATEGORIES'));

        return self::buildFromArray($categories);
    }
}

class ImportFromGoogleCategory extends Command
{
    protected $signature = 'import:from_google:categories {--force : Force the operation to run when in production.}';

    protected $description = 'Import categories from Google';

    public function handle()
    {
        if (! $this->option('force')
      && \App::environment('production')
      && ! $this->confirm('This will reset the DB, continue ?')) {
            die();
        }

        DB::statement('TRUNCATE '.DB::connection()->getTablePrefix().(new Category)->getTable().' RESTART IDENTITY CASCADE');

        $all = CategoryFromGoogle::all(true)['roots'];

        $root = new Category(['title' => 'root', 'slug' => 'root']);
        $root->saveAsRoot();

        $fn_import_categories = function ($parent, $children, $level = 0) use (&$fn_import_categories) {
            echo str_repeat("\t", $level)."[+] Working on: '$parent->title' (id: $parent->id, slug: $parent->slug)\n";

            if (empty($children)) {
                echo str_repeat("\t", $level)."[=] No more children\n";
            }

            foreach ($children as $child) {
                $node = Category::create([
                    'title' => ucfirst($child->title),
                    'gender' => $child->gender,
                ], $parent);

                echo str_repeat("\t", $level + 1)."[+] Added a child: '$node->title' (id: $node->id, slug: $node->slug)\n";

                $fn_import_categories($node, $child->children, $level + 2);
            }
        };

        $fn_import_categories($root, $all);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsIToProducts extends Migration
{
    public static function prefix()
    {
        return DB::connection()->getTablePrefix();
    }

    private $view_name = 'products';

    private function __up($table_name)
    {
        DB::unprepared('alter table '.$table_name.' add column i serial primary key');
    }

    private function __down($table_name)
    {
        DB::unprepared('alter table '.$table_name.' drop column if exists i');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up($up = true)
    {
        if ('postgres' != config('database.default')) {
            return;
        }

        $view_name = self::prefix().$this->view_name;
        $definition = DB::select('select definition from pg_views where viewname = ?', [$view_name]);
        $definition = $definition[0]->definition;

        $tables = array_filter(DB::connection()->getDoctrineSchemaManager()->listTableNames(),
          function ($v) use ($view_name) {
              return false !== strpos($v, $view_name);
          });

        DB::unprepared("drop view $view_name");

        foreach ($tables as $table_name) {
            $up ? $this->__up($table_name) : $this->__down($table_name);
        }

        preg_match('/select ([a-z0-9_]+)\./i', $definition, $matches);
        $current_table_name = $matches[1];

        DB::unprepared("create view $view_name as select * from $current_table_name");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        return $this->up(false);
    }
}

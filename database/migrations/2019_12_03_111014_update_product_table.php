<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductTable extends Migration
{
    public static function prefix()
    {
        return DB::connection()->getTablePrefix();
    }

    private $view_name = 'products';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up($new_type = 'text')
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

        DB::unprepared('drop view '.$view_name);

        foreach ($tables as $table_name) {
            DB::unprepared('alter table '.$table_name.' alter column payload type '.$new_type);
        }

        DB::unprepared('create view '.$view_name.' as '.$definition);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        return $this->up('json using payload::json');
    }
}

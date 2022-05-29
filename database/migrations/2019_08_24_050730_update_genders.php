<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Gender;
use App\Models\Product;
use App\Models\WhiteList;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGenders extends Migration
{
    private static $classes = [
        Brand::class,
        Category::class,
        Product::class,
        WhiteList::class,
    ];

    private static function getTableName($class)
    {
        return \DB::connection()->getTablePrefix().(new $class)->getTable();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ('postgres' == config('database.default')) {
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('json', 'text');

            $w_tname = self::getTableName(WhiteList::class);
            $c_name = $w_tname.'_gender_check';

            DB::unprepared('ALTER TABLE '.$w_tname.' DROP CONSTRAINT IF EXISTS '.$c_name);
        }

        foreach (self::$classes as $class) {
            Schema::table((new $class)->getTable(), function (Blueprint $table) {
                $table->string('gender')->default(null)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameProductsTable extends Migration
{
    public static function prefix()
    {
        return DB::connection()->getTablePrefix();
    }

    private $old_name = 'products';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $new_name = $this->old_name.'_'.time();

        Schema::rename($this->old_name, $new_name);
        DB::unprepared('create view '.self::prefix().$this->old_name.' as select * from '.self::prefix().$new_name);
        DB::unprepared('drop table if exists temp_products');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop view if exists '.self::prefix().$this->old_name);
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['slug']);
        });
        (new CreateProductsTable)->up();
        (new RemoveIdFromProducts)->up();
    }
}

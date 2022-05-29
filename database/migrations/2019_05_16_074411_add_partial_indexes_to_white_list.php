<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartialIndexesToWhiteList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('white_lists', function (Blueprint $table) {
            $table->dropUnique(['brand', 'category', 'gender']);

            DB::unprepared('CREATE UNIQUE INDEX white_lists_brand_category_gender_unique_1 ON ss_xyz_white_lists (brand, category, gender) WHERE category IS NOT NULL');
            DB::unprepared('CREATE UNIQUE INDEX white_lists_brand_category_gender_unique_2 ON ss_xyz_white_lists (brand, gender) WHERE category IS NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('white_lists', function (Blueprint $table) {
            $table->unique(['brand', 'category', 'gender']);

            DB::unprepared('DROP INDEX white_lists_brand_category_gender_unique_1');
            DB::unprepared('DROP INDEX white_lists_brand_category_gender_unique_2');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWhiteLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('white_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
        });

        DB::unprepared('update ss_xyz_white_lists set "brand_id"=(select id from ss_xyz_brands where slug=brand limit 1)');
        DB::unprepared('update ss_xyz_white_lists set "category_id"=(select id from ss_xyz_categories where slug=category limit 1)');

        DB::unprepared('delete from ss_xyz_white_lists where brand_id is null');
        DB::unprepared('delete from ss_xyz_white_lists where category_id is null');

        Schema::table('white_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable(false)->change();
        });

        DB::unprepared('DROP INDEX white_lists_brand_category_gender_unique_1');
        DB::unprepared('DROP INDEX white_lists_brand_category_gender_unique_2');

        DB::unprepared('CREATE UNIQUE INDEX white_lists_brand_category_gender_unique_1 ON ss_xyz_white_lists (brand_id, category_id, gender) WHERE category_id IS NOT NULL');
        DB::unprepared('CREATE UNIQUE INDEX white_lists_brand_category_gender_unique_2 ON ss_xyz_white_lists (brand_id, gender) WHERE category_id IS NULL');

        Schema::table('white_lists', function (Blueprint $table) {
            if ('sqlite' == config('database.default')) {
                return;
            }

            $table->dropColumn('brand');
            $table->dropColumn('category');
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
            $table->string('brand')->nullable();
            $table->string('category')->nullable();
        });

        DB::unprepared('update ss_xyz_white_lists set "brand"=(select slug from ss_xyz_brands where id=brand_id limit 1)');
        DB::unprepared('update ss_xyz_white_lists set "category"=(select slug from ss_xyz_categories where id=category_id limit 1)');

        Schema::table('white_lists', function (Blueprint $table) {
            $table->string('brand')->nullable(false)->change();
        });

        DB::unprepared('DROP INDEX white_lists_brand_category_gender_unique_1');
        DB::unprepared('DROP INDEX white_lists_brand_category_gender_unique_2');

        DB::unprepared('CREATE UNIQUE INDEX white_lists_brand_category_gender_unique_1 ON ss_xyz_white_lists (brand, category, gender) WHERE category IS NOT NULL');
        DB::unprepared('CREATE UNIQUE INDEX white_lists_brand_category_gender_unique_2 ON ss_xyz_white_lists (brand, gender) WHERE category IS NULL');

        Schema::table('white_lists', function (Blueprint $table) {
            $table->dropColumn('brand_id');
            $table->dropColumn('category_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWhiteLists2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('white_lists', function (Blueprint $table) {
            if ('sqlite' != config('database.default')) {
                $table->dropForeign(['brand_id']);
                $table->dropForeign(['category_id']);
            }

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
            if ('sqlite' != config('database.default')) {
                $table->dropForeign(['brand_id']);
                $table->dropForeign(['category_id']);
            }

            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }
}

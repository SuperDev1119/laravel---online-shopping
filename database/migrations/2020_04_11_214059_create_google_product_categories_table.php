<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_product_categories', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->text('name');
            $table->timestamps();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->integer('google_product_category_id')->nullable();

            $table->foreign('google_product_category_id')->references('id')
                ->on('google_product_categories')->onDelete('set null');

            $table->foreign('parent_id')->references('id')
                ->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['google_product_category_id']);
            $table->dropForeign(['parent_id']);
            $table->dropColumn('google_product_category_id');
        });

        Schema::dropIfExists('google_product_categories');
    }
}

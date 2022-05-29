<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_types', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('text')->nullable();

            $table->timestamps();
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_type_id')->nullable();
            $table->foreign('brand_type_id')
                ->references('id')
                ->on('brand_types')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropForeign(['brand_type_id']);
            $table->dropColumn(['brand_type_id']);
        });
        Schema::dropIfExists('brand_types');
    }
}

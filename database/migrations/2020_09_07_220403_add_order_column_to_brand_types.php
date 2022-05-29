<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderColumnToBrandTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_types', function (Blueprint $table) {
            $table->integer('order_column')->default(0);
        });

        DB::unprepared('update ss_xyz_brand_types set "order_column"="id"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_types', function (Blueprint $table) {
            $table->dropColumn('order_column');
        });
    }
}

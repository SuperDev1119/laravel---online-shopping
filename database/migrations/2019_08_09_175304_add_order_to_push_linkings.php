<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderToPushLinkings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('push_linkings', function (Blueprint $table) {
            $table->integer('order_column')->default(0);
        });

        DB::unprepared('update ss_xyz_push_linkings set "order_column"="id"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('push_linkings', function (Blueprint $table) {
            $table->dropColumn('order_column');
        });
    }
}

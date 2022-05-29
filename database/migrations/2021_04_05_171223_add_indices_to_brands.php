<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndicesToBrands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->index('name');
            $table->index('display_name');

            $table->index('in_listing');
            $table->index('is_top');
            $table->index(['in_listing', 'is_top']);
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
            $table->dropIndex(['name']);
            $table->dropIndex(['display_name']);

            $table->dropIndex(['in_listing']);
            $table->dropIndex(['is_top']);
            $table->dropIndex(['in_listing', 'is_top']);
        });
    }
}

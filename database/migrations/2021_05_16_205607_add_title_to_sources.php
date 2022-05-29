<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleToSources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->string('title')->nullable();
        });

        DB::unprepared('update ss_xyz_sources set "title"="name"');

        if ('postgres' == config('database.default')) {
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('json', 'text');
        }

        Schema::table('sources', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
}

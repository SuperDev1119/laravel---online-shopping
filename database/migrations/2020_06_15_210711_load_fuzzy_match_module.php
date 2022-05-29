<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LoadFuzzyMatchModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ('postgres' == config('database.default')) {
            DB::unprepared('create extension if not exists fuzzystrmatch');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ('postgres' == config('database.default')) {
            DB::unprepared('drop extension if exists fuzzystrmatch');
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeStampsToModels extends Migration
{
    private $tables = [
        'white_lists',
        'colors',
        'color_white_list',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->dropTimestamps();
            });
        }
    }
}

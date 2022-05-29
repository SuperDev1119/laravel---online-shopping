<?php

use App\Models\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhiteListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('white_lists', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('gender')->default(Gender::GENDER_BOTH);
            $table->string('brand');
            $table->string('category')->nullable();
            $table->boolean('in_sitemap');
            $table->json('colors')->nullable();

            $table->unique(['brand', 'category', 'gender']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('white_lists');
    }
}

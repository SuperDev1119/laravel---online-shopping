<?php

use App\Models\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable();
            $table->string('slug')->index();
            $table->text('description')->nullable();

            $table->string('brand_original')->nullable();
            $table->string('merchant_original')->nullable();
            $table->string('currency_original')->nullable();

            $table->text('category_original')->nullable();
            $table->text('color_original')->nullable();

            $table->float('price');
            $table->float('old_price');
            $table->smallInteger('reduction');

            $table->text('url');
            $table->text('image_url');
            $table->string('gender')->default(Gender::GENDER_BOTH);
            $table->string('provider')->nullable();

            $table->text('col')->nullable();
            $table->text('coupe')->nullable();
            $table->text('manches')->nullable();
            $table->text('material')->nullable();
            $table->text('model')->nullable();
            $table->text('motifs')->nullable();
            $table->text('event')->nullable();
            $table->text('style')->nullable();
            $table->text('size')->nullable();
            $table->text('livraison')->nullable();

            $table->json('payload')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

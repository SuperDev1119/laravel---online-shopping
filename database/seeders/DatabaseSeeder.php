<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App::environment('production')) {
            die('Cannot run this in production');
        }

        Schema::disableForeignKeyConstraints();

        Model::unguard();

        $this->call([
            FaqItemSeeder::class,
            CategorySeeder::class,
            GoogleProductCategorySeeder::class,
            PushGridSeeder::class,
            \Encore\Admin\Auth\Database\AdminTablesSeeder::class,
            AdminMenuSeeder::class,
        ]);
        \Encore\Admin\Helpers\Helpers::import();

        Schema::enableForeignKeyConstraints();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Artisan::call('import:from_google:categories --force');
    }
}

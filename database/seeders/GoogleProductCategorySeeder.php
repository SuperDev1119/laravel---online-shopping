<?php

namespace Database\Seeders;

use App\Models\GoogleProductCategory;
use Illuminate\Database\Seeder;

class GoogleProductCategorySeeder extends Seeder
{
    public function run()
    {
        $lang = str_replace('_', '-', config('app.locale'));

        $lang = ('en' == $lang) ? 'en-GB' : $lang;

        $array = file('https://www.google.com/basepages/producttype/taxonomy-with-ids.'.$lang.'.txt');
        array_shift($array);

        foreach ($array as $value) {
            list($id, $name) = explode(' - ', $value, 2);

            GoogleProductCategory::insertOrIgnore([
                'id' => $id,
                'name' => trim($name),
            ]);
        }
    }
}

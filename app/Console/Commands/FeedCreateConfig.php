<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Gender;
use Illuminate\Console\Command;

class FeedCreateConfig extends Command
{
    protected $signature = 'feed:create-config';

    protected $description = '';

    private function getConfigValue($category, $gender)
    {
        $_gender = $gender;

        if ($gender == Gender::GENDER_BOTH) {
            $gender = null;
            $route = route('get.products.byCategory', [
                'category' => $category,
            ], false);
        } else {
            $route = route('get.products.byGender.byCategory', [
                'gender' => $gender,
                'category' => $category,
            ], false);
        }

        return [
            'url' => str_replace('//', '/', $route),
            'title' => trim(implode(' ', [
                text_for_seo__category(['category_title' => $category->title]),
                text_for_seo__gender(['gender' => $gender]),
            ])),
            'gender' => $_gender,
            'category' => $category->slug,
        ];
    }

    public function handle()
    {
        try {
            $categories = Category::root()->descendants;
        } catch (\Exception $e) {
            $categories = [];
        }

        $arr = [];
        foreach ($categories as $category) {
            foreach (Gender::genders() as $gender) {
                if (Gender::areMatching($gender, $category->gender)) {
                    $arr[] = $this->getConfigValue($category, $gender);
                }
            }
        }

        $content = "<?php\n\nreturn ".var_export($arr, true).';';
        $file = 'config/feed.config.php';

        if (false !== file_put_contents($file, $content)) {
            $this->info("'$file' has been overwritten with success.");
        } else {
            $this->error("Error writing into '$file'");
        }
    }
}

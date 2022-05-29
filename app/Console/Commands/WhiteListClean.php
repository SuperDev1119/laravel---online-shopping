<?php

namespace App\Console\Commands;

use App\Libraries\ElasticsearchHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\ColorWhiteList;
use App\Models\Gender;
use App\Models\ProductFromElasticsearch;
use App\Models\WhiteList;
use Illuminate\Console\Command;

class WhiteListClean extends Command
{
    protected $signature = 'white_list:clean {brands?*}';

    protected $description = 'Cleans orphans WhiteList for specified Brands (or all non_listing brands if none specified)';

    public function handle()
    {
        $brands = [];
        $opts_brands = $this->argument('brands');

        if (empty($opts_brands)) {
            $query = Brand::where('in_listing', false);
        } else {
            $query = Brand::whereIn('slug', $opts_brands);
        }

        $brands = $query->get();

        $i = 0;
        $numbers_of_brands = $query->count();

        foreach ($brands as $brand) {
            echo "\r[+] Progress [brands: $i/{$numbers_of_brands}]: ";
            $nb = WhiteList::where('brand_id', $brand->id)->delete();

            if ($nb > 0) {
                echo "$nb removed ($brand - {$brand->slug})\n";
            }
            $i++;
        }

        $nb = WhiteList::whereNotIn('brand_id', Brand::all()->pluck('id'))->delete();
        echo "[+] Removed $nb records with unexisting Brands\n";
    }
}

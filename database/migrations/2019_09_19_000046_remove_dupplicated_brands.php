<?php

use App\Models\Brand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDupplicatedBrands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (Brand::all() as $brand) {
            if ($brand->isPublic()) {
                continue;
            }

            if (preg_match('/^(.*)-[1-9]$/', $brand->slug, $matches)) {
                $slug = $matches[1];

                if (Brand::where('slug', $slug)->exists()) {
                    \Log::debug("[+] Deleting the Brand (id: $brand->id, name: $brand->name, slug: $brand->slug)");
                    $brand->delete();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

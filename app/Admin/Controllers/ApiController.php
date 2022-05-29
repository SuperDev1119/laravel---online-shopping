<?php

namespace App\Admin\Controllers;

use App\Models\Brand;
use App\Models\BrandType;
use App\Models\Category;
use App\Models\GoogleProductCategory;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RootController;

class ApiController extends RootController
{
    use ValidatesRequests;

    public function brands(Request $request)
    {
        $q = $request->get('q');

        return Brand::where('name', 'ilike', "%$q%")->paginate(null, ['id', 'name as text']);
    }

    public function categories(Request $request)
    {
        $q = $request->get('q');

        return Category::where('title', 'ilike', "%$q%")->paginate(null, ['id', 'title as text']);
    }

    public function google_product_categories(Request $request)
    {
        $q = $request->get('q');

        return GoogleProductCategory::where('name', 'ilike', "%$q%")->paginate(null, ['id', 'name as text']);
    }
}

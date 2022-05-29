<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\FooterCms;
use App\Models\Product;
use App\Models\ProductFromElasticsearch;
use App\Models\TextRef;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request as Input;

class ApiController extends BaseController
{
    public function products($product_slug)
    {
        try {
            $product = Product::findOrFail($product_slug);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            try {
                $product = ProductFromElasticsearch::get($product_slug);
            } catch (\Exception $e) {
                abort(404, _i("Ce produit n'a pas été trouvé 😭"));
            }
        }

        return response()->json($product);
    }

    public function categories(Request $request)
    {
        $categories = Category::withoutRoot();
        if ($depth = $request->get('depth')) {
            $categories = $categories->where('depth', $depth);
        }
        if ($order = $request->get('order')) {
            $categories = $categories->orderBy($order, 'ASC');
        }

        return response()->json($categories->get()->map(function ($category) {
            return [
                'slug' => $category->slug,
                'title' => $category->title,
                'gender' => $category->gender,
                'depth' => $category->depth,
            ];
        }));
    }

    public function brands()
    {
        $query = Brand::query()->with('brand_type');

        if ($q = trim(Input::get('query'))) {
            $query = $query
        ->where('name', 'ilike', "%$q%")
        ->orwhere('display_name', 'ilike', "%$q%");
        }

        return $query->orderBy('is_top', 'desc')->orderBy('in_listing', 'desc')->paginate();
    }
}

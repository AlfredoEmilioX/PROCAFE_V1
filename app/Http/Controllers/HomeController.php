<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Si es admin, mándalo al panel
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        // ---- Lógica actual de la tienda (deja la tuya) ----
        $q        = (string) $request->input('q', '');
        $category = $request->input('category');
        $brand    = $request->input('brand');
        $min      = $request->input('min');
        $max      = $request->input('max');
        $sort     = $request->input('sort', 'new');

        $products = Product::query()
            ->when($q, fn($qq) => $qq->where('name','like',"%$q%"))
            ->when($category, fn($qq) => $qq->where('category_id', $category))
            ->when($brand, fn($qq) => $qq->where('brand_id', $brand))
            ->when($min !== null && $min !== '', fn($qq) => $qq->where('price','>=',$min))
            ->when($max !== null && $max !== '', fn($qq) => $qq->where('price','<=',$max))
            ->when($sort === 'price_asc',  fn($qq) => $qq->orderBy('price','asc'))
            ->when($sort === 'price_desc', fn($qq) => $qq->orderBy('price','desc'))
            ->when($sort === 'new',        fn($qq) => $qq->latest())
            ->paginate(12)
            ->withQueryString();

        $categories = Category::select('categories_id','name')->orderBy('name')->get();
        $brands     = Brand::select('brands_id','name')->orderBy('name')->get();

        return view('home', compact(
            'products','categories','brands','q','category','brand','min','max','sort'
        ));
    }
}

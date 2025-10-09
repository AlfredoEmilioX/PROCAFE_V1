<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(10);
        return view('admin.products.products-index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        return view('admin.products.products-create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'slug'         => 'required|string|max:255|unique:products,slug',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'status'       => 'required|in:active,inactive',
            'categories_id'=> 'required|exists:categories,categories_id',
            'brands_id'    => 'nullable|exists:brands,brands_id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description'  => 'nullable|string',
        ]);

        $data = $request->only(['name','slug','price','stock','status','categories_id','brands_id','description']);

        // Subir imagen
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/products', 'public');
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('ok', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        return view('admin.products.products-edit', compact('product','categories','brands'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'slug'         => 'required|string|max:255|unique:products,slug,' . ($product->id ?? 'NULL') . ',id',
            'price'        => 'required|numeric|min:0', 
            'stock'        => 'required|integer|min:0',
            'status'       => 'required|in:active,inactive',
            'categories_id'=> 'required|exists:categories,categories_id',
            'brands_id'    => 'nullable|exists:brands,brands_id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description'  => 'nullable|string',
        ]);

        $data = $request->only(['name','slug','price','stock','status','categories_id','brands_id','description']);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('uploads/products', 'public');
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('ok', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        if ($product->image && file_exists(public_path('storage/'.$product->image))) {
            unlink(public_path('storage/'.$product->image));
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('ok', 'Producto eliminado correctamente.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(10);
        return view('admin.brands.brands-index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.brands-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'slug' => 'required|string|max:255|unique:brands,slug',
            'description' => 'nullable|string',
        ]);

        Brand::create($request->only('name', 'slug', 'description'));
        return redirect()->route('admin.brands.index')->with('ok', 'Marca creada correctamente.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.brands-edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->brands_id . ',brands_id',
            'slug' => 'required|string|max:255|unique:brands,slug,' . $brand->brands_id . ',brands_id',
            'description' => 'nullable|string',
        ]);

        $brand->update($request->only('name', 'slug', 'description'));
        return redirect()->route('admin.brands.index')->with('ok', 'Marca actualizada correctamente.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('ok', 'Marca eliminada correctamente.');
    }
}

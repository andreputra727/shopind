<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $products = $query->latest()->get();
        $kategoriAktif = $request->kategori;

        return view('products.index', compact('products', 'kategoriAktif'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
}
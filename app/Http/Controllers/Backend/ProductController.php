<?php


namespace App\Http\Controllers\Backend;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController
{
    public function index()
    {
        $products = Product::all();

        return view('backend.product.index')->withProducts($products);
    }

    public function create()
    {
        return view('backend.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
        ]);


        Product::create($request->except('_token'));

        return redirect()->route('admin.products.index')->withFlashSuccess(__('The Product was successfully created.'));;
    }
}

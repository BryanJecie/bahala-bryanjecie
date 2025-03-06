<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use DB;
use Illuminate\Http\Request;

/**
 * Class HomeController.
 */
class ProductController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('frontend.user.product');
    }


    public function getAllProducts()
    {
        $products = Product::get();
        return response()->json($products);
    }


    public function  addToCart(Request $request)
    {
        $user = $request->user();
        $user->purchases()->create([
            'product_id' => $request->product_id,
            'qty' => 1
        ]);

        return response()->json(true);
    }


    public function  getPurchases(Request $request)
    {
        $user = $request->user();

        $purchases = $user->purchases()
            ->with('product')
            ->select('product_id', DB::raw('SUM(qty) as total_quantity'))
            ->whereNull('paid_at')
            ->groupBy('product_id')
            ->get();

        // Attach product prices separately
        $purchases->each(function ($purchase) {
            $purchase->total_price = $purchase->total_quantity * optional($purchase->product)->price;
        });

        return response()->json($purchases);
    }

    public function removeToCart(Request $request)
    {
        $user = $request->user();

        $purchase = $user->purchases()
            ->with('product')
            ->whereNull('paid_at')
            ->where('product_id', $request->product_id)
            ->first();

        if ($purchase) {
            $purchase->delete();
        }

        return response()->json(true);
    }
}

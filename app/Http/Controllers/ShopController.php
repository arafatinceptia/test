<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        // Fetch all non-featured products
        $products = Product::where('is_featured', false)
            ->with(['variants'])
            ->latest()
            ->paginate(12);

        return view('shop.index', compact('products'));
    }
}

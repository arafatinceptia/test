<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $product = Product::with(['variants', 'reviews' => function ($query) {
            $query->where('is_approved', true);
        }, 'faqs'])
        ->where('is_featured', true)
        ->latest()
        ->first();

        return view('landing', compact('product'));
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Non-Featured Products
        for ($i = 1; $i <= 5; $i++) {
            $product = Product::create([
                'name' => "Medicine Product $i",
                'slug' => "medicine-product-$i",
                'description' => "This is a description for medicine product $i. It is effective for common ailments.",
                'how_to_use' => "Take twice daily after meals.",
                'is_featured' => false,
                'seo_title' => "Buy Medicine Product $i",
                'seo_description' => "Best price for Medicine Product $i.",
            ]);

            ProductVariant::create([
                'product_id' => $product->id,
                'name' => '100ml Bottle',
                'price' => 10.00 + $i,
                'stock_quantity' => 20,
            ]);

            ProductVariant::create([
                'product_id' => $product->id,
                'name' => '200ml Bottle',
                'price' => 18.00 + $i,
                'stock_quantity' => 10,
            ]);
        }
    }
}

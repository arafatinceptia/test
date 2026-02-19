<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\User;
use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FrontendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a user for reviews
        $user = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            ['name' => 'John Doe', 'password' => Hash::make('password'), 'role' => 'customer']
        );

        // Create Featured Product
        $product = Product::create([
            'name' => 'Super Immunity Booster',
            'slug' => 'super-immunity-booster',
            'description' => 'A powerful blend of vitamins and minerals to boost your immune system and keep you healthy all year round.',
            'how_to_use' => "Take one capsule daily with water.\nDo not exceed the recommended dose.\nConsult your doctor if you are pregnant or breastfeeding.",
            'is_featured' => true,
            'seo_title' => 'Buy Super Immunity Booster - Best Price',
            'seo_description' => 'Boost your immunity with our top-rated supplement.',
        ]);

        // Create Variants
        ProductVariant::create([
            'product_id' => $product->id,
            'name' => '30 Capsules (1 Month Supply)',
            'price' => 29.99,
            'stock_quantity' => 100,
        ]);

        ProductVariant::create([
            'product_id' => $product->id,
            'name' => '90 Capsules (3 Month Supply)',
            'price' => 79.99,
            'stock_quantity' => 50,
        ]);

        ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Trial Pack (7 Days)',
            'price' => 9.99,
            'stock_quantity' => 0, // Out of stock test
        ]);

        // Create Reviews (Approved and Unapproved)
        Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'This product changed my life! I feel so much more energetic.',
            'is_approved' => true,
        ]);

        Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 4,
            'comment' => 'Great product, but shipping was a bit slow.',
            'is_approved' => true,
        ]);

        Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 1,
            'comment' => 'Spam review not approved yet.',
            'is_approved' => false,
        ]);

        // Create FAQs
        Faq::create([
            'product_id' => $product->id,
            'question' => 'Is this safe for children?',
            'answer' => 'This product is recommended for adults 18+. Please consult a pediatrician for children.',
        ]);

        Faq::create([
            'product_id' => $product->id,
            'question' => 'What are the ingredients?',
            'answer' => 'Vitamin C, Zinc, Elderberry extract, and Echinacea.',
        ]);
    }
}

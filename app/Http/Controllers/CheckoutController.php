<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        // 1. Check if session has cart
        if (!Session::has('cart') || empty(Session::get('cart'))) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cart = Session::get('cart');
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        // 2. Validate input
        $request->validate([
            'shipping_address' => 'required|string',
            'whatsapp_number' => 'required_without:telegram_number',
            'telegram_number' => 'required_without:whatsapp_number',
        ]);

        $cart = Session::get('cart');

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty');
        }

        try {
            DB::beginTransaction();

            $total = 0;
            foreach ($cart as $id => $details) {
                $total += $details['price'] * $details['quantity'];
            }

            // 3. Create Order
            $order = Order::create([
                'user_id' => auth()->id(), // Nullable
                'status' => 'pending',
                'grand_total' => $total,
                'shipping_address' => $request->shipping_address,
                'whatsapp_number' => $request->whatsapp_number,
                'telegram_number' => $request->telegram_number,
                'payment_method' => 'COD',
            ]);

            // 4. Create Order Items & Update Stock
            foreach ($cart as $id => $details) {
                $variant = ProductVariant::lockForUpdate()->find($id);

                if (!$variant) {
                    throw new \Exception("Product variant not found: " . $details['name']);
                }

                if ($variant->stock_quantity < $details['quantity']) {
                    throw new \Exception("Insufficient stock for: " . $details['name']);
                }

                $variant->decrement('stock_quantity', $details['quantity']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $id,
                    'quantity' => $details['quantity'],
                    'unit_price' => $details['price'],
                ]);
            }

            DB::commit();

            // 5. Clear Cart
            Session::forget('cart');

            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}

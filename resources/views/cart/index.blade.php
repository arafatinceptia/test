@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Your Cart</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if(empty($cart))
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <p class="text-gray-500 text-lg mb-4">Your cart is currently empty.</p>
            <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Continue Shopping</a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 text-gray-600 font-medium text-left">
                    <tr>
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Quantity</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($cart as $id => $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $item['name'] }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                ${{ number_format($item['price'], 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                           class="w-16 rounded border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                                           min="1">
                                    <button type="submit" class="text-indigo-600 hover:text-indigo-800 text-sm">Update</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800">
                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex flex-col md:flex-row justify-between items-center bg-gray-50 p-6 rounded-lg border border-gray-200">
            <div class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">
                Grand Total: <span class="text-indigo-600">${{ number_format($total, 2) }}</span>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('shop.index') }}" class="px-6 py-3 bg-white text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                    Continue Shopping
                </a>
                <a href="{{ route('checkout.index') }}" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition shadow">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Checkout</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Order Summary -->
        <div class="md:w-1/3 order-last md:order-last">
            <div class="bg-white rounded-lg shadow p-6 border border-gray-100 sticky top-4">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Order Summary</h2>
                <ul class="space-y-4 mb-4">
                    @foreach($cart as $item)
                        <li class="flex justify-between">
                            <span class="text-gray-600">{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                            <span class="font-medium text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="border-t pt-4 flex justify-between items-center font-bold text-lg text-gray-900">
                    <span>Total</span>
                    <span class="text-indigo-600">${{ number_format($total, 2) }}</span>
                </div>
                <div class="mt-6 text-sm text-gray-500">
                    Payment Method: <span class="font-semibold text-gray-700">Cash on Delivery (COD)</span>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="md:w-2/3">
            <form action="{{ route('checkout.store') }}" method="POST" class="bg-white rounded-lg shadow p-8 border border-gray-100">
                @csrf
                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Shipping Details</h2>

                <div class="mb-6">
                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                    <textarea name="shipping_address" id="shipping_address" rows="4" required
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="+1234567890">
                        @error('whatsapp_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="telegram_number" class="block text-sm font-medium text-gray-700 mb-2">Telegram Number</label>
                        <input type="text" name="telegram_number" id="telegram_number" value="{{ old('telegram_number') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="@username or Number">
                        @error('telegram_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <p class="text-gray-500 text-sm italic mb-6">* Please provide at least one contact number.</p>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition shadow-lg flex justify-center items-center">
                    Place Order (COD)
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

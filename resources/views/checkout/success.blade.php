@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8 text-center border border-gray-100">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Order Placed Successfully!</h2>
        <p class="text-gray-600 mb-6">Thank you for your order. We have received your request and will contact you shortly for confirmation.</p>

        <div class="bg-indigo-50 rounded-lg p-4 mb-8">
            <p class="text-sm text-gray-500 uppercase font-semibold">Order ID</p>
            <p class="text-2xl font-bold text-indigo-700">#{{ $order->id }}</p>
        </div>

        <a href="{{ route('shop.index') }}" class="inline-block bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition">
            Continue Shopping
        </a>
    </div>
</div>
@endsection

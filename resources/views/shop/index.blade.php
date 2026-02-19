@extends('layouts.app')

@section('title', 'Shop - Non-Featured Medicines')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Shop All Medicines</h1>

    @if($products->isEmpty())
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <p class="text-gray-500 text-lg">No products available at the moment.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden border border-gray-100 flex flex-col">
                    <div class="h-48 bg-indigo-50 flex items-center justify-center text-indigo-400">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $product->name }}</h2>
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $product->description }}</p>
                        </div>

                        <div class="mt-4 space-y-3">
                            @foreach($product->variants as $variant)
                                <div class="flex justify-between items-center border-t pt-3">
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $variant->name }}</div>
                                        <div class="text-indigo-600 font-bold">${{ number_format($variant->price, 2) }}</div>
                                    </div>

                                    @if($variant->stock_quantity > 0)
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_variant_id" value="{{ $variant->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="bg-indigo-600 text-white px-3 py-1.5 rounded text-sm hover:bg-indigo-700 transition">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-red-500 text-sm font-medium">Out of Stock</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection

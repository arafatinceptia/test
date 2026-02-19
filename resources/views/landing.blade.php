@extends('layouts.app')

@section('title', $product ? $product->seo_title ?? $product->name : 'Home')
@section('meta_description', $product ? $product->seo_description : '')

@section('content')

@if(!$product)
    <div class="text-center py-20">
        <h2 class="text-2xl font-bold text-gray-700">No Featured Product Found.</h2>
        <p class="text-gray-500 mt-2">Please check back later.</p>
    </div>
@else

    <!-- Hero Section -->
    <section class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
        <div class="md:flex">
            <div class="md:flex-shrink-0 md:w-1/2">
                 <!-- Placeholder image if no featured image logic implemented yet, or use a default -->
                <div class="h-64 w-full bg-indigo-100 flex items-center justify-center text-indigo-500">
                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="p-8 md:w-1/2 flex flex-col justify-center">
                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Featured Medicine</div>
                <h1 class="block mt-1 text-3xl leading-tight font-extrabold text-gray-900">{{ $product->name }}</h1>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    {{ $product->description }}
                </p>
                <div class="mt-6">
                    <a href="#variants" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-indigo-700 transition">
                        View Options
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Use Section -->
    @if($product->how_to_use)
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">How to Use</h2>
        <div class="bg-indigo-50 p-6 rounded-lg border-l-4 border-indigo-500 text-gray-700 leading-relaxed whitespace-pre-line">
            {{ $product->how_to_use }}
        </div>
    </section>
    @endif

    <!-- Product Variants Grid -->
    <section id="variants" class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Available Options</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($product->variants as $variant)
                <div class="bg-white rounded-lg shadow p-6 flex flex-col justify-between border border-gray-100 hover:shadow-lg transition">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $variant->name }}</h3>
                        <div class="mt-2 text-3xl font-bold text-indigo-600">${{ number_format($variant->price, 2) }}</div>
                        <div class="mt-1 text-sm {{ $variant->stock_quantity > 0 ? 'text-green-600' : 'text-red-500' }}">
                            {{ $variant->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                        </div>
                    </div>

                    @if($variant->stock_quantity > 0)
                        <a href="https://wa.me/1234567890?text={{ urlencode('I want to buy ' . $product->name . ' - ' . $variant->name) }}"
                           target="_blank"
                           class="mt-6 block w-full text-center bg-green-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-green-600 transition flex items-center justify-center gap-2">
                            <span>Buy on WhatsApp</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                    @else
                        <button disabled class="mt-6 w-full bg-gray-300 text-gray-500 cursor-not-allowed px-4 py-2 rounded-md font-semibold">
                            Out of Stock
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <!-- Customer Reviews Section -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Customer Reviews</h2>

        @if($product->reviews->isEmpty())
            <p class="text-gray-500 italic">No reviews yet. Be the first to review!</p>
        @else
            <div class="space-y-4">
                @foreach($product->reviews as $review)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= $review->rating)
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="ml-2 text-sm font-semibold text-gray-700">by {{ $review->user->name ?? 'Anonymous' }}</span>
                            <span class="ml-auto text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- FAQ Accordion Section -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Frequently Asked Questions</h2>

        @if($product->faqs->isEmpty())
            <p class="text-gray-500 italic">No FAQs available for this product.</p>
        @else
            <div class="space-y-2">
                @foreach($product->faqs as $faq)
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg bg-white">
                        <button @click="open = !open" class="w-full px-4 py-3 text-left font-medium text-gray-900 bg-gray-50 hover:bg-gray-100 focus:outline-none flex justify-between items-center rounded-t-lg">
                            <span>{{ $faq->question }}</span>
                            <svg class="w-5 h-5 transform transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" class="px-4 py-3 text-gray-700 border-t border-gray-200" x-transition>
                            {{ $faq->answer }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

@endif

@endsection

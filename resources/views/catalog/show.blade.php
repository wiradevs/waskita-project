@extends('layouts.app')
@section('title', $product->name . ' — ' . $settings->get('company_name', 'Waskita'))
@section('description', $product->short_description ?? $product->name)

@section('content')
@php
    $waNumber = preg_replace('/[^0-9]/', '', $settings->get('company_whatsapp', ''));
    $waMsg = urlencode("Halo, saya ingin memesan:\n\n📦 *{$product->name}*" .
             ($product->formatted_price ? "\n💰 {$product->formatted_price}" : '') .
             "\n\nURL: " . request()->fullUrl() .
             "\n\nMohon informasi lebih lanjut. Terima kasih!");
@endphp

{{-- ── Breadcrumb ───────────────────────────────────── --}}
<div style="background:#EDE8DF;border-bottom:1px solid #E5DDD5;" class="py-4">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">
        <nav class="flex items-center gap-1 text-xs flex-wrap" style="color:#A8A29E;font-family:'Inter',sans-serif;">
            <a href="{{ route('home') }}" class="transition" style="color:#78716C;"
               onmouseover="this.style.color='#B8965A'" onmouseout="this.style.color='#78716C'">Beranda</a>
            <svg class="w-3 h-3 mx-1 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('catalog.index') }}" class="transition" style="color:#78716C;"
               onmouseover="this.style.color='#B8965A'" onmouseout="this.style.color='#78716C'">Katalog</a>
            <svg class="w-3 h-3 mx-1 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('catalog.index', ['kategori' => $product->category->slug]) }}"
               class="transition" style="color:#78716C;"
               onmouseover="this.style.color='#B8965A'" onmouseout="this.style.color='#78716C'">
                {{ $product->category->name }}
            </a>
            <svg class="w-3 h-3 mx-1 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span style="color:#1C1917;font-weight:500;">{{ Str::limit($product->name, 40) }}</span>
        </nav>
    </div>
</div>

{{-- ── Product Detail ───────────────────────────────── --}}
<section class="py-16" style="background:#FAF8F5;">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-start">

            {{-- ── Gallery ──────────────────────────── --}}
            <div data-animate>
                @php
                    $allImages = $product->images->count()
                        ? $product->images->map(fn($img) => Storage::url($img->image_path))->toArray()
                        : ($product->thumbnail ? [$product->thumbnail_url] : []);
                    $firstImage = $allImages[0] ?? null;
                @endphp

                {{-- Main image --}}
                <div class="relative overflow-hidden mb-4" style="aspect-ratio:4/5;background:#EDE8DF;">
                    @if($firstImage)
                        <img id="main-image" src="{{ $firstImage }}" alt="{{ $product->name }}"
                             class="w-full h-full object-cover"
                             style="transition:opacity 0.25s ease,transform 0.25s ease;">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span style="font-family:'Playfair Display',serif;font-size:5rem;opacity:0.15;color:#1C1917;">
                                {{ substr($product->name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                    @if($product->is_featured)
                    <div class="absolute top-4 left-4 px-3 py-1 text-xs tracking-widest uppercase"
                         style="background:#B8965A;color:#FAF8F5;font-family:'Inter',sans-serif;">
                        Unggulan
                    </div>
                    @endif
                </div>

                {{-- Thumbnail strip --}}
                @if(count($allImages) > 1)
                <div class="flex gap-2 overflow-x-auto pb-1">
                    @foreach($allImages as $imgSrc)
                    <button onclick="window.changeImage('{{ $imgSrc }}')"
                            class="flex-shrink-0 w-20 h-20 overflow-hidden border-2 transition"
                            style="border-color:#E5DDD5;"
                            onmouseover="this.style.borderColor='#B8965A'"
                            onmouseout="this.style.borderColor='#E5DDD5'">
                        <img src="{{ $imgSrc }}" alt="" loading="lazy" decoding="async" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ── Info Panel ───────────────────────── --}}
            <div class="lg:sticky lg:top-28">
                {{-- Category --}}
                <div data-animate class="flex items-center gap-3 mb-5">
                    <div class="h-px w-8" style="background:#B8965A;"></div>
                    <a href="{{ route('catalog.index', ['kategori' => $product->category->slug]) }}"
                       class="text-xs tracking-widest uppercase font-medium transition"
                       style="color:#B8965A;font-family:'Inter',sans-serif;">
                        {{ $product->category->name }}
                    </a>
                </div>

                {{-- Name --}}
                <h1 data-animate data-delay="100"
                    style="font-family:'Playfair Display',serif;font-size:clamp(1.75rem,3vw,2.5rem);font-weight:600;color:#1C1917;line-height:1.2;margin-bottom:1.25rem;">
                    {{ $product->name }}
                </h1>

                {{-- Price --}}
                <div data-animate data-delay="150" class="mb-6">
                    @if($product->formatted_price)
                        <p class="text-2xl font-semibold" style="color:#1C1917;font-family:'Inter',sans-serif;">
                            {{ $product->formatted_price }}
                        </p>
                    @else
                        <p class="text-sm italic" style="color:#A8A29E;font-family:'Inter',sans-serif;">
                            Hubungi kami untuk informasi harga
                        </p>
                    @endif
                </div>

                <div data-animate data-delay="170" style="height:1px;background:#E5DDD5;margin-bottom:1.5rem;"></div>

                {{-- Short description --}}
                @if($product->short_description)
                <p data-animate data-delay="200" class="leading-relaxed mb-5"
                   style="color:#78716C;font-family:'Inter',sans-serif;font-size:1rem;font-weight:300;">
                    {{ $product->short_description }}
                </p>
                @endif

                {{-- Full description --}}
                @if($product->description)
                <div data-animate data-delay="240" class="mb-8 leading-loose"
                     style="color:#78716C;font-family:'Inter',sans-serif;font-size:0.9375rem;font-weight:300;">
                    {!! nl2br(e($product->description)) !!}
                </div>
                @endif

                {{-- WA CTA --}}
                @if($waNumber)
                <div data-animate data-delay="300" class="flex flex-col sm:flex-row gap-3 mb-8">
                    <a href="https://wa.me/{{ $waNumber }}?text={{ $waMsg }}"
                       target="_blank"
                       class="flex-1 flex items-center justify-center gap-3 py-4 text-xs tracking-widest uppercase font-semibold transition-all hover:opacity-90"
                       style="background:#B8965A;color:#FAF8F5;font-family:'Inter',sans-serif;">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Pesan via WhatsApp
                    </a>
                    <a href="{{ route('catalog.index', ['kategori' => $product->category->slug]) }}"
                       class="flex items-center justify-center gap-2 py-4 px-6 text-xs tracking-widest uppercase font-semibold border transition"
                       style="border-color:#E5DDD5;color:#78716C;font-family:'Inter',sans-serif;">
                        Koleksi Lain
                    </a>
                </div>
                @endif

                {{-- Meta grid --}}
                <div data-animate data-delay="350" class="grid grid-cols-2 gap-3 pt-6" style="border-top:1px solid #E5DDD5;">
                    <div class="p-4" style="background:#EDE8DF;">
                        <p class="text-xs tracking-widest uppercase mb-1" style="color:#A8A29E;font-family:'Inter',sans-serif;">Kategori</p>
                        <p class="text-sm font-medium" style="color:#1C1917;font-family:'Inter',sans-serif;">{{ $product->category->name }}</p>
                    </div>
                    <div class="p-4" style="background:#EDE8DF;">
                        <p class="text-xs tracking-widest uppercase mb-1" style="color:#A8A29E;font-family:'Inter',sans-serif;">Status</p>
                        <p class="text-sm font-medium" style="color:#1C1917;font-family:'Inter',sans-serif;">
                            {{ $product->is_active ? 'Tersedia' : 'Tidak Tersedia' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Related Products ─────────────────────────────── --}}
@if($related->count())
<section class="py-20" style="background:#EDE8DF;">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">
        <div class="mb-12 text-center">
            <div data-animate class="deco-rule justify-center mb-5">Terkait</div>
            <h2 data-animate data-delay="100"
                style="font-family:'Playfair Display',serif;font-size:clamp(1.5rem,3vw,2rem);font-weight:600;color:#1C1917;">
                Produk Serupa
            </h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($related as $i => $relItem)
            <div data-animate data-delay="{{ ($i % 4) * 80 }}"
                 class="product-card group" style="background:#FAF8F5;">
                <a href="{{ route('catalog.show', $relItem->slug) }}"
                   class="block relative overflow-hidden" style="aspect-ratio:3/4;">
                    @if($relItem->thumbnail)
                        <img src="{{ $relItem->thumbnail_url }}" alt="{{ $relItem->name }}"
                             loading="lazy" decoding="async"
                             class="card-img w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background:#EDE8DF;">
                            <span style="font-family:'Playfair Display',serif;font-size:2rem;opacity:0.2;color:#1C1917;">
                                {{ substr($relItem->name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                </a>
                <div class="p-4" style="border-top:1px solid #E5DDD5;">
                    <a href="{{ route('catalog.show', $relItem->slug) }}">
                        <h4 style="font-family:'Playfair Display',serif;font-size:0.9375rem;font-weight:500;color:#1C1917;line-height:1.3;"
                            class="hover:underline underline-offset-2 line-clamp-1 transition">
                            {{ $relItem->name }}
                        </h4>
                    </a>
                    @if($relItem->formatted_price)
                    <p class="text-xs mt-1.5" style="color:#78716C;font-family:'Inter',sans-serif;">
                        {{ $relItem->formatted_price }}
                    </p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

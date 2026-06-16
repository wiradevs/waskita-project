@extends('layouts.app')
@section('title', 'Koleksi Produk — ' . $settings->get('company_name', 'Waskita'))

@section('content')
@php
    $waNumber = preg_replace('/[^0-9]/', '', $settings->get('company_whatsapp', ''));
@endphp

{{-- ── Page Header ──────────────────────────────────── --}}
@php
    $catVideo = $settings->get('catalog_video');
    $catImage = $settings->get('catalog_image');
    $catHasMedia = $catVideo || $catImage;
@endphp
<section class="relative overflow-hidden text-center"
         style="min-height:{{ $catHasMedia ? '340px' : 'auto' }};background:#EDE8DF;display:flex;align-items:center;justify-content:center;padding:{{ $catHasMedia ? '0' : '5rem 0' }}">

    @if($catVideo)
        <video muted loop playsinline preload="none"
               data-lazy-video="{{ Storage::url($catVideo) }}"
               @if($catImage) poster="{{ Storage::url($catImage) }}" @endif
               style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;background:#EDE8DF;">
        </video>
    @elseif($catImage)
        <img src="{{ Storage::url($catImage) }}" alt=""
             style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;">
    @endif

    @if($catHasMedia)
        <div style="position:absolute;inset:0;z-index:1;background:rgba(28,25,23,0.55);"></div>
        <div style="position:absolute;inset:0;z-index:1;background:linear-gradient(to top,rgba(28,25,23,0.7) 0%,transparent 60%);"></div>
    @endif

    <div class="max-w-3xl mx-auto px-5" style="position:relative;z-index:10;padding-top:5rem;padding-bottom:5rem;">
        <div data-animate class="deco-rule justify-center mb-6" style="{{ $catHasMedia ? 'color:#B8965A' : '' }}">Koleksi</div>
        <h1 data-animate data-delay="100"
            style="font-family:'Playfair Display',serif;font-size:clamp(2rem,4vw,3rem);font-weight:600;line-height:1.2;color:{{ $catHasMedia ? '#FAF8F5' : '#1C1917' }};">
            @if($activeCategory)
                {{ $categories->firstWhere('slug', $activeCategory)?->name ?? 'Kategori' }}
            @else
                Semua Koleksi
            @endif
        </h1>
        <p data-animate data-delay="200" class="mt-4 text-base"
           style="font-family:'Inter',sans-serif;font-weight:300;color:{{ $catHasMedia ? 'rgba(250,248,245,0.72)' : '#78716C' }};">
            @if(request('cari'))
                Hasil pencarian untuk "<em>{{ request('cari') }}</em>"
            @else
                Temukan furniture yang sempurna untuk ruang Anda
            @endif
        </p>
    </div>
</section>

{{-- ── Main Layout ──────────────────────────────────── --}}
<section class="py-16" style="background:#FAF8F5;">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">
        <div class="flex flex-col lg:flex-row gap-10">

            {{-- ── Sidebar ────────────────────────────── --}}
            <aside class="lg:w-64 flex-shrink-0">
                <div class="sticky top-24">

                    {{-- Search form --}}
                    <form method="GET" action="{{ route('catalog.index') }}" class="mb-8">
                        <div class="relative">
                            <input type="text" name="cari" value="{{ request('cari') }}"
                                   placeholder="Cari produk..."
                                   class="w-full px-4 py-3 pr-10 text-sm border outline-none transition"
                                   style="border-color:#E5DDD5;color:#1C1917;background:#FAF8F5;font-family:'Inter',sans-serif;"
                                   onfocus="this.style.borderColor='#B8965A'"
                                   onblur="this.style.borderColor='#E5DDD5'">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2" style="color:#B8965A;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                                </svg>
                            </button>
                            @if(request('kategori'))
                                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                            @endif
                        </div>
                    </form>

                    {{-- Category filter --}}
                    <div>
                        <h3 class="text-xs tracking-widest uppercase font-semibold mb-5" style="color:#1C1917;font-family:'Inter',sans-serif;">
                            Kategori
                        </h3>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('catalog.index', request()->only('cari')) }}"
                                   class="flex items-center justify-between py-2.5 text-sm border-b transition"
                                   style="border-color:#E5DDD5;font-family:'Inter',sans-serif;color:{{ !$activeCategory ? '#B8965A' : '#78716C' }};font-weight:{{ !$activeCategory ? '600' : '400' }};">
                                    <span>Semua</span>
                                    <span class="text-xs" style="color:#A8A29E;">{{ $categories->sum('products_count') }}</span>
                                </a>
                            </li>
                            @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('catalog.index', array_merge(request()->only('cari'), ['kategori' => $cat->slug])) }}"
                                   class="flex items-center justify-between py-2.5 text-sm border-b transition"
                                   style="border-color:#E5DDD5;font-family:'Inter',sans-serif;color:{{ $activeCategory === $cat->slug ? '#B8965A' : '#78716C' }};font-weight:{{ $activeCategory === $cat->slug ? '600' : '400' }};">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-xs" style="color:#A8A29E;">{{ $cat->products_count }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @if(request()->hasAny(['cari', 'kategori']))
                        <a href="{{ route('catalog.index') }}"
                           class="inline-flex items-center gap-1 mt-5 text-xs tracking-widest uppercase"
                           style="color:#A8A29E;font-family:'Inter',sans-serif;">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reset
                        </a>
                        @endif
                    </div>
                </div>
            </aside>

            {{-- ── Product Grid ─────────────────────── --}}
            <div class="flex-1 min-w-0">

                {{-- Count bar --}}
                <div class="flex items-center justify-between mb-8 pb-5" style="border-bottom:1px solid #E5DDD5;">
                    <p class="text-xs tracking-widest uppercase" style="color:#A8A29E;font-family:'Inter',sans-serif;">
                        {{ $products->total() }} Produk
                    </p>
                    @if($products->total() > 0)
                    <p class="text-xs" style="color:#A8A29E;font-family:'Inter',sans-serif;">
                        {{ $products->firstItem() }}–{{ $products->lastItem() }} ditampilkan
                    </p>
                    @endif
                </div>

                @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach($products as $i => $product)
                    @php
                        $waMsg = urlencode("Halo, saya ingin memesan:\n\n📦 *{$product->name}*" .
                                 ($product->formatted_price ? "\n💰 {$product->formatted_price}" : '') .
                                 "\n\nMohon informasi lebih lanjut. Terima kasih!");
                    @endphp
                    <div data-animate data-delay="{{ (($i % 3) * 80) }}"
                         class="product-card group flex flex-col" style="background:#FAF8F5;border:1px solid #E5DDD5;">
                        {{-- Image --}}
                        <a href="{{ route('catalog.show', $product->slug) }}"
                           class="block relative overflow-hidden" style="aspect-ratio:3/4;">
                            @if($product->thumbnail)
                                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                     loading="lazy" decoding="async"
                                     class="card-img w-full h-full object-cover">
                            @else
                                <div class="card-img w-full h-full flex items-center justify-center" style="background:#EDE8DF;">
                                    <span style="font-family:'Playfair Display',serif;font-size:3rem;opacity:0.2;color:#1C1917;">
                                        {{ substr($product->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Hover WA overlay --}}
                            <div class="card-overlay absolute inset-0 flex items-end justify-center pb-5"
                                 style="background:rgba(28,25,23,0.4);">
                                @if($waNumber)
                                <a href="https://wa.me/{{ $waNumber }}?text={{ $waMsg }}"
                                   target="_blank"
                                   onclick="event.stopPropagation()"
                                   class="flex items-center gap-2 px-5 py-2.5 text-xs tracking-widest uppercase font-semibold"
                                   style="background:#B8965A;color:#FAF8F5;font-family:'Inter',sans-serif;">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    Pesan Sekarang
                                </a>
                                @endif
                            </div>
                        </a>

                        {{-- Info --}}
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <p class="text-xs tracking-widest uppercase mb-1.5" style="color:#B8965A;font-family:'Inter',sans-serif;">
                                    {{ $product->category->name }}
                                </p>
                                <a href="{{ route('catalog.show', $product->slug) }}">
                                    <h3 style="font-family:'Playfair Display',serif;font-size:1.0625rem;font-weight:500;color:#1C1917;line-height:1.3;"
                                        class="hover:underline decoration-gold underline-offset-2 transition line-clamp-2">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                @if($product->short_description)
                                <p class="text-sm mt-2 line-clamp-2" style="color:#78716C;font-family:'Inter',sans-serif;">
                                    {{ $product->short_description }}
                                </p>
                                @endif
                            </div>
                            <div class="flex items-center justify-between mt-4 pt-4" style="border-top:1px solid #E5DDD5;">
                                @if($product->formatted_price)
                                    <span class="text-sm font-medium" style="color:#1C1917;font-family:'Inter',sans-serif;">
                                        {{ $product->formatted_price }}
                                    </span>
                                @else
                                    <span class="text-xs italic" style="color:#A8A29E;font-family:'Inter',sans-serif;">
                                        Hubungi kami
                                    </span>
                                @endif
                                <a href="{{ route('catalog.show', $product->slug) }}"
                                   class="flex items-center gap-1 text-xs tracking-widest uppercase transition hover:gap-2"
                                   style="color:#78716C;font-family:'Inter',sans-serif;">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($products->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
                @endif

                @else
                {{-- Empty state --}}
                <div class="text-center py-24">
                    <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center" style="border:1px solid #E5DDD5;">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24" style="color:#B8965A;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <h3 style="font-family:'Playfair Display',serif;font-size:1.375rem;color:#1C1917;margin-bottom:0.5rem;">
                        Produk tidak ditemukan
                    </h3>
                    <p class="text-sm mb-6" style="color:#78716C;font-family:'Inter',sans-serif;">
                        Coba ubah filter atau kata kunci pencarian Anda
                    </p>
                    <a href="{{ route('catalog.index') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 text-xs tracking-widest uppercase font-semibold"
                       style="background:#1C1917;color:#FAF8F5;font-family:'Inter',sans-serif;">
                        Lihat Semua Produk
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

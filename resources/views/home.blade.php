@extends('layouts.app')
@section('title', $settings->get('company_name', 'Waskita') . ' — ' . $settings->get('company_tagline', 'Premium Furniture'))

@section('content')
@php
    $waNumber = preg_replace('/[^0-9]/', '', $settings->get('company_whatsapp', ''));
    $waGeneral = $waNumber ? "https://wa.me/{$waNumber}?text=" . urlencode("Halo, saya ingin konsultasi mengenai produk furniture Anda.") : '#';
@endphp

{{-- ── HERO ─────────────────────────────────────────── --}}
@php $hasVideo = (bool)$settings->get('hero_video'); $hasImage = (bool)$settings->get('hero_image'); @endphp
<section id="hero-section" class="relative overflow-hidden" style="background:#0E0C0A;min-height:82vh;">

    {{-- ── Page-load curtain ───────────────────────── --}}
    <div id="hero-curtain"></div>

    {{-- ── Media Background ───────────────────────── --}}
    @if($hasVideo)
    <video id="hero-video" autoplay muted loop playsinline
           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;">
        <source src="{{ Storage::url($settings->get('hero_video')) }}" type="video/mp4">
    </video>
    @elseif($hasImage)
    <div style="position:absolute;inset:0;z-index:0;">
        <img src="{{ Storage::url($settings->get('hero_image')) }}"
             alt="" style="width:100%;height:100%;object-fit:cover;">
    </div>
    @else
    <div style="position:absolute;inset:0;z-index:0;background:radial-gradient(ellipse at 60% 40%,rgba(184,150,90,0.12) 0%,transparent 65%),#0E0C0A;"></div>
    @endif

    {{-- ── Overlay ─────────────────────────────────── --}}
    <div style="position:absolute;inset:0;z-index:1;background:rgba(14,12,10,0.68);pointer-events:none;"></div>
    <div style="position:absolute;inset:0;z-index:1;background:linear-gradient(to top,rgba(14,12,10,0.7) 0%,transparent 40%);pointer-events:none;"></div>

    {{-- ── Content ─────────────────────────────────── --}}
    <div style="position:relative;z-index:10;min-height:82vh;display:flex;align-items:center;padding-top:4.5rem;padding-bottom:4rem;">
        <div class="w-full px-5 sm:px-8 lg:px-10" style="max-width:900px;margin:0 auto;text-align:center;">

            {{-- ── Outer frame (landscape panel) ─── --}}
            <div class="hero-frame" style="position:relative;display:inline-block;width:100%;">

                {{-- Corner diamond ornaments --}}
                <span class="hc-diamond" style="top:-5px;left:-5px;"></span>
                <span class="hc-diamond" style="top:-5px;right:-5px;"></span>
                <span class="hc-diamond" style="bottom:-5px;left:-5px;"></span>
                <span class="hc-diamond" style="bottom:-5px;right:-5px;"></span>

                {{-- Inner recessed panel --}}
                <div style="position:absolute;inset:6px;border:1px solid rgba(184,150,90,0.13);pointer-events:none;"></div>

                {{-- Content padding --}}
                <div style="padding:2rem 3.5rem 1.875rem;">

                    {{-- Top ornament bar --}}
                    <div class="hero-fade-label" style="display:flex;align-items:center;justify-content:center;gap:0.875rem;margin-bottom:1.375rem;">
                        <div style="height:1px;flex:1;background:linear-gradient(90deg,transparent,rgba(184,150,90,0.4));"></div>
                        <span style="font-size:0.58rem;letter-spacing:0.38em;text-transform:uppercase;font-weight:500;color:#B8965A;font-family:'Inter',sans-serif;white-space:nowrap;">
                            {{ $settings->get('company_name', 'Waskita') }} &ensp;·&ensp; Premium Furniture
                        </span>
                        <div style="height:1px;flex:1;background:linear-gradient(90deg,rgba(184,150,90,0.4),transparent);"></div>
                    </div>

                    {{-- Headline --}}
                    <h1 style="font-family:'Playfair Display',serif;font-size:clamp(1.875rem,3.8vw,3rem);font-weight:600;line-height:1.12;color:#FAF8F5;margin:0;">
                        <div class="hero-line hero-line-1">
                            <span class="line-inner">{{ $settings->get('hero_title', 'Ruang yang Bercerita,') }}</span>
                        </div>
                        <div class="hero-line hero-line-2">
                            <span class="line-inner" style="color:#D4AF7A;font-style:italic;">{{ $settings->get('company_tagline', 'Furnitur yang Menginspirasi.') }}</span>
                        </div>
                    </h1>

                    {{-- Ornamental divider with center diamond --}}
                    <div class="hero-separator" style="display:flex;align-items:center;justify-content:center;gap:0.75rem;margin:1.375rem auto;max-width:280px;">
                        <div style="height:1px;flex:1;background:rgba(184,150,90,0.45);"></div>
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="#B8965A" style="flex-shrink:0;opacity:0.8;">
                            <polygon points="4,0 8,4 4,8 0,4"/>
                        </svg>
                        <div style="height:1px;flex:1;background:rgba(184,150,90,0.45);"></div>
                    </div>

                    {{-- Subtitle --}}
                    <p class="hero-slide-1" style="font-size:0.8125rem;line-height:1.85;color:rgba(250,248,245,0.55);font-family:'Inter',sans-serif;font-weight:300;margin:0 auto 1.625rem;max-width:460px;">
                        {{ $settings->get('hero_subtitle', 'Furniture premium dengan desain timeless — menceritakan karakter dan gaya hidup Anda.') }}
                    </p>

                    {{-- CTAs --}}
                    <div class="hero-slide-2" style="display:flex;flex-wrap:wrap;gap:0.625rem;justify-content:center;margin-bottom:1.75rem;">
                        <a href="{{ route('catalog.index') }}" class="hero-primary-btn"
                           style="display:inline-flex;align-items:center;gap:0.6rem;padding:0.688rem 1.625rem;font-size:0.58rem;letter-spacing:0.25em;text-transform:uppercase;font-weight:600;background:#B8965A;color:#FAF8F5;font-family:'Inter',sans-serif;text-decoration:none;">
                            Jelajahi Koleksi
                            <svg class="hero-arrow" style="width:0.8rem;height:0.8rem;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"/>
                            </svg>
                        </a>
                        @if($waNumber)
                        <a href="{{ $waGeneral }}" target="_blank"
                           style="display:inline-flex;align-items:center;padding:0.688rem 1.625rem;font-size:0.58rem;letter-spacing:0.25em;text-transform:uppercase;font-weight:600;border:1px solid rgba(250,248,245,0.22);color:rgba(250,248,245,0.72);font-family:'Inter',sans-serif;text-decoration:none;transition:border-color 0.3s;">
                            Konsultasi Gratis
                        </a>
                        @endif
                    </div>

                    {{-- Stats strip --}}
                    <div class="hero-slide-3" style="display:flex;align-items:center;justify-content:center;border-top:1px solid rgba(184,150,90,0.18);padding-top:1.125rem;">
                        <div style="padding:0 2rem;text-align:center;">
                            <div class="hero-stat" data-target="500" data-suffix="+"
                                 style="font-family:'Playfair Display',serif;font-size:1.25rem;font-weight:600;color:#FAF8F5;line-height:1;">0+</div>
                            <div style="font-size:0.52rem;letter-spacing:0.25em;text-transform:uppercase;margin-top:0.25rem;color:rgba(184,150,90,0.6);font-family:'Inter',sans-serif;">Produk</div>
                        </div>
                        <div style="width:1px;height:1.75rem;background:rgba(184,150,90,0.2);flex-shrink:0;"></div>
                        <div style="padding:0 2rem;text-align:center;">
                            <div class="hero-stat" data-target="10" data-suffix="+"
                                 style="font-family:'Playfair Display',serif;font-size:1.25rem;font-weight:600;color:#FAF8F5;line-height:1;">0+</div>
                            <div style="font-size:0.52rem;letter-spacing:0.25em;text-transform:uppercase;margin-top:0.25rem;color:rgba(184,150,90,0.6);font-family:'Inter',sans-serif;">Tahun</div>
                        </div>
                        <div style="width:1px;height:1.75rem;background:rgba(184,150,90,0.2);flex-shrink:0;"></div>
                        <div style="padding:0 2rem;text-align:center;">
                            <div class="hero-stat" data-target="1000" data-suffix="+"
                                 style="font-family:'Playfair Display',serif;font-size:1.25rem;font-weight:600;color:#FAF8F5;line-height:1;">0+</div>
                            <div style="font-size:0.52rem;letter-spacing:0.25em;text-transform:uppercase;margin-top:0.25rem;color:rgba(184,150,90,0.6);font-family:'Inter',sans-serif;">Pelanggan</div>
                        </div>
                    </div>

                </div>{{-- /content padding --}}
            </div>{{-- /hero-frame --}}
        </div>
    </div>

    {{-- ── Video controls ───────────────────────────── --}}
    @if($hasVideo)
    <button id="video-toggle"
            style="position:absolute;bottom:1.5rem;right:1.5rem;z-index:20;width:36px;height:36px;border-radius:50%;border:1px solid rgba(250,248,245,0.2);background:rgba(14,12,10,0.45);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:border-color 0.3s;"
            aria-label="Pause/Play video">
        <svg id="icon-pause" style="width:12px;height:12px;color:#FAF8F5;" fill="currentColor" viewBox="0 0 24 24">
            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
        </svg>
        <svg id="icon-play" style="width:12px;height:12px;color:#FAF8F5;display:none;" fill="currentColor" viewBox="0 0 24 24">
            <path d="M8 5v14l11-7z"/>
        </svg>
    </button>
    <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:rgba(250,248,245,0.06);z-index:20;">
        <div id="video-progress" style="height:100%;width:0%;background:#B8965A;transition:width 0.5s linear;"></div>
    </div>
    @endif

</section>

<style>
/* ── Curtain ──────────────────────────────────────────── */
#hero-curtain {
    position:absolute;inset:0;z-index:100;background:#0E0C0A;
    transform-origin:top;
    animation:curtainReveal 1.0s cubic-bezier(0.77,0,0.175,1) 0.1s both;
    pointer-events:none;
}
@keyframes curtainReveal { 0%{transform:scaleY(1);} 100%{transform:scaleY(0);} }

/* ── Frame box ────────────────────────────────────────── */
.hero-frame {
    border:1px solid rgba(184,150,90,0.32);
    opacity:0;
    animation:heroFadeFrame 0.8s ease 0.7s forwards;
}
@keyframes heroFadeFrame { to { opacity:1; } }

/* ── Corner diamond ornaments ─────────────────────────── */
.hc-diamond {
    position:absolute;width:9px;height:9px;
    background:#B8965A;
    transform:rotate(45deg);
    opacity:0;
    animation:hcFade 0.5s ease 1.1s forwards;
}
@keyframes hcFade { to { opacity:0.85; } }

/* ── Label ────────────────────────────────────────────── */
.hero-fade-label {
    opacity:0;
    animation:heroFadeLabel 0.7s ease 1.0s forwards;
}
@keyframes heroFadeLabel { to { opacity:1; } }

/* ── Headline reveal ──────────────────────────────────── */
.hero-line { overflow:hidden; }
.hero-line .line-inner {
    display:block;transform:translateY(105%);opacity:0;
    animation:heroLineUp 0.9s cubic-bezier(0.22,1,0.36,1) both;
}
.hero-line-1 .line-inner { animation-delay:1.05s; }
.hero-line-2 .line-inner { animation-delay:1.2s; }
@keyframes heroLineUp { to { transform:translateY(0);opacity:1; } }

/* ── Separator ────────────────────────────────────────── */
.hero-separator {
    transform:scaleX(0);transform-origin:center;
    animation:heroScaleX 0.8s cubic-bezier(0.22,1,0.36,1) 1.35s both;
}
@keyframes heroScaleX { to { transform:scaleX(1); } }

/* ── Slide-up sequence ───────────────────────────────── */
.hero-slide-1,.hero-slide-2,.hero-slide-3 {
    opacity:0;transform:translateY(18px);
    animation:heroSlideUp 0.8s cubic-bezier(0.22,1,0.36,1) both;
}
.hero-slide-1 { animation-delay:1.45s; }
.hero-slide-2 { animation-delay:1.58s; }
.hero-slide-3 { animation-delay:1.7s; }
@keyframes heroSlideUp { to { opacity:1;transform:translateY(0); } }

/* ── CTA ─────────────────────────────────────────────── */
.hero-primary-btn { transition:opacity 0.25s; }
.hero-primary-btn:hover { opacity:0.85; }
.hero-primary-btn .hero-arrow { transition:transform 0.3s cubic-bezier(0.22,1,0.36,1); }
.hero-primary-btn:hover .hero-arrow { transform:translateX(4px); }

/* ── Video toggle ────────────────────────────────────── */
#video-toggle:hover { border-color:rgba(184,150,90,0.6); }

/* ── Scroll dot ──────────────────────────────────────── */
@keyframes scrollDot { 0%{transform:translateY(-100%);} 100%{transform:translateY(100%);} }
</style>

{{-- ── CATEGORIES ───────────────────────────────────── --}}
@if($categories->count())
<section class="py-24" style="background:#FAF8F5;">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">

        {{-- Section header --}}
        <div class="text-center mb-14">
            <div data-animate class="deco-rule justify-center mb-6">Koleksi Kami</div>
            <h2 data-animate data-delay="100"
                style="font-family:'Playfair Display',serif;font-size:clamp(1.75rem,3vw,2.5rem);font-weight:600;color:#1C1917;">
                Temukan Gaya Ruang Anda
            </h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            @foreach($categories as $i => $category)
            <a data-animate data-delay="{{ ($i % 6) * 80 }}"
               href="{{ route('catalog.index', ['kategori' => $category->slug]) }}"
               class="group relative overflow-hidden"
               style="aspect-ratio:3/4;background:#EDE8DF;">
                @if($category->image)
                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                         class="card-img w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg,#EDE8DF,#D5CCC2);">
                        <span style="font-family:'Playfair Display',serif;font-size:2rem;opacity:0.3;color:#1C1917;">
                            {{ substr($category->name, 0, 1) }}
                        </span>
                    </div>
                @endif
                {{-- Overlay --}}
                <div class="absolute inset-0 flex flex-col items-center justify-end p-4 pb-5 transition-all duration-400"
                     style="background:linear-gradient(to top, rgba(28,25,23,0.8) 0%, rgba(28,25,23,0.2) 50%, transparent 100%);">
                    <p class="text-xs tracking-widest uppercase font-medium text-center mb-1"
                       style="color:#FAF8F5;font-family:'Inter',sans-serif;">{{ $category->name }}</p>
                    <p class="text-xs" style="color:#B8965A;font-family:'Inter',sans-serif;">
                        {{ $category->products_count }} item
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── FEATURED PRODUCTS ───────────────────────────── --}}
@if($featuredProducts->count())
<section class="py-24" style="background:#EDE8DF;">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14 gap-4">
            <div>
                <div data-animate class="deco-rule mb-5">Unggulan</div>
                <h2 data-animate data-delay="100"
                    style="font-family:'Playfair Display',serif;font-size:clamp(1.75rem,3vw,2.5rem);font-weight:600;color:#1C1917;">
                    Produk Terpilih
                </h2>
            </div>
            <a data-animate data-delay="200" href="{{ route('catalog.index') }}"
               class="inline-flex items-center gap-2 text-xs tracking-widest uppercase font-medium transition-all hover:gap-4"
               style="color:#B8965A;font-family:'Inter',sans-serif;">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($featuredProducts as $i => $product)
            @php
                $waMsg = urlencode("Halo, saya ingin memesan:\n\n📦 *{$product->name}*" .
                         ($product->formatted_price ? "\n💰 {$product->formatted_price}" : '') .
                         "\n\nMohon informasi lebih lanjut. Terima kasih!");
            @endphp
            <div data-animate data-delay="{{ ($i % 3) * 100 }}"
                 class="product-card group flex flex-col" style="background:#FAF8F5;">
                {{-- Image --}}
                <a href="{{ route('catalog.show', $product->slug) }}" class="block relative overflow-hidden" style="aspect-ratio:3/4;">
                    @if($product->thumbnail)
                        <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                             class="card-img w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background:#EDE8DF;">
                            <span style="font-family:'Playfair Display',serif;font-size:3rem;opacity:0.2;color:#1C1917;">
                                {{ substr($product->name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                    {{-- Hover overlay --}}
                    <div class="card-overlay absolute inset-0 flex items-end justify-center pb-6"
                         style="background:rgba(28,25,23,0.45);">
                        @if($waNumber)
                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMsg }}"
                           target="_blank"
                           class="flex items-center gap-2 px-6 py-3 text-xs tracking-widest uppercase font-semibold"
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
                <div class="p-5 flex-1 flex flex-col justify-between" style="border-top:1px solid #E5DDD5;">
                    <div>
                        <p class="text-xs tracking-widest uppercase mb-1.5" style="color:#B8965A;font-family:'Inter',sans-serif;">
                            {{ $product->category->name }}
                        </p>
                        <a href="{{ route('catalog.show', $product->slug) }}">
                            <h3 style="font-family:'Playfair Display',serif;font-size:1.125rem;font-weight:500;color:#1C1917;line-height:1.3;"
                                class="hover:text-gold transition">
                                {{ $product->name }}
                            </h3>
                        </a>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        @if($product->formatted_price)
                            <span class="text-sm font-medium" style="color:#44403C;font-family:'Inter',sans-serif;">
                                {{ $product->formatted_price }}
                            </span>
                        @else
                            <span class="text-sm" style="color:#A8A29E;font-family:'Inter',sans-serif;font-style:italic;">
                                Hubungi kami
                            </span>
                        @endif
                        <a href="{{ route('catalog.show', $product->slug) }}"
                           class="text-xs tracking-widest uppercase transition-all hover:gap-2 flex items-center gap-1"
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
    </div>
</section>
@endif

{{-- ── BRAND STATEMENT ─────────────────────────────── --}}
<section class="py-28 text-center relative overflow-hidden" style="background:#1C1917;">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-64 h-64 rounded-full -mt-20 -ml-20" style="background:#B8965A;"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full -mb-32 -mr-32" style="background:#B8965A;"></div>
    </div>
    <div class="relative z-10 max-w-3xl mx-auto px-5 sm:px-8">
        <div data-animate class="deco-rule justify-center mb-8" style="color:#B8965A;">Filosofi Kami</div>
        <blockquote data-animate data-delay="150"
                    style="font-family:'Playfair Display',serif;font-size:clamp(1.5rem,3vw,2.25rem);font-weight:400;font-style:italic;color:#FAF8F5;line-height:1.4;margin-bottom:2rem;">
            "Furniture bukan sekadar benda — ia adalah cerminan dari siapa Anda, dan bagaimana Anda ingin menjalani hidup."
        </blockquote>
        <div data-animate data-delay="250" class="flex flex-col items-center gap-4">
            <div class="w-10 h-px" style="background:#B8965A;"></div>
            <p class="text-xs tracking-widest uppercase" style="color:#78716C;font-family:'Inter',sans-serif;">
                {{ $settings->get('company_name', 'Waskita') }}
            </p>
        </div>
    </div>
</section>

{{-- ── ABOUT PREVIEW ───────────────────────────────── --}}
@if($settings->get('company_about'))
<section class="py-24" style="background:#FAF8F5;">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            {{-- Decorative image block --}}
            <div data-animate class="relative">
                <div class="aspect-[4/5] relative" style="background:#EDE8DF;">
                    @if($settings->get('hero_image'))
                        <img src="{{ Storage::url($settings->get('hero_image')) }}"
                             alt="About" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span style="font-family:'Playfair Display',serif;font-size:5rem;opacity:0.15;color:#1C1917;">
                                {{ substr($settings->get('company_name', 'W'), 0, 1) }}
                            </span>
                        </div>
                    @endif
                    {{-- Decorative gold border --}}
                    <div class="absolute -bottom-4 -right-4 border" style="width:80%;height:80%;border-color:#B8965A;z-index:-1;"></div>
                </div>
            </div>

            {{-- Text --}}
            <div>
                <div data-animate class="deco-rule mb-6">Tentang Kami</div>
                <h2 data-animate data-delay="100"
                    style="font-family:'Playfair Display',serif;font-size:clamp(1.75rem,3vw,2.5rem);font-weight:600;color:#1C1917;margin-bottom:1.5rem;line-height:1.2;">
                    Crafted with<br><em>Passion &amp; Precision</em>
                </h2>
                <p data-animate data-delay="200" class="leading-relaxed mb-8"
                   style="color:#78716C;font-family:'Inter',sans-serif;font-weight:300;font-size:1.0625rem;">
                    {{ Str::limit($settings->get('company_about'), 280) }}
                </p>
                <div data-animate data-delay="300" class="flex flex-wrap gap-4">
                    <a href="{{ route('about') }}"
                       class="inline-flex items-center gap-2 px-7 py-3.5 text-xs tracking-widest uppercase font-semibold transition-all"
                       style="background:#1C1917;color:#FAF8F5;font-family:'Inter',sans-serif;">
                        Selengkapnya
                    </a>
                    @if($waNumber)
                    <a href="{{ $waGeneral }}" target="_blank"
                       class="inline-flex items-center gap-2 px-7 py-3.5 text-xs tracking-widest uppercase font-semibold border transition-all hover:bg-charcoal hover:text-cream hover:border-charcoal"
                       style="border-color:#1C1917;color:#1C1917;font-family:'Inter',sans-serif;">
                        Hubungi Kami
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ── CTA BANNER ───────────────────────────────────── --}}
<section class="py-20" style="background:#B8965A;">
    <div class="max-w-5xl mx-auto px-5 text-center">
        <h2 data-animate style="font-family:'Playfair Display',serif;font-size:clamp(1.75rem,3vw,2.5rem);font-weight:600;color:#FAF8F5;margin-bottom:1rem;">
            Wujudkan Ruang Impian Anda
        </h2>
        <p data-animate data-delay="100" class="mb-8 text-base"
           style="color:rgba(250,248,245,0.8);font-family:'Inter',sans-serif;font-weight:300;">
            Konsultasikan kebutuhan furniture Anda bersama tim kami. Gratis, tanpa komitmen.
        </p>
        @if($waNumber)
        <a data-animate data-delay="200"
           href="{{ $waGeneral }}" target="_blank"
           class="inline-flex items-center gap-3 px-8 py-4 text-xs tracking-widest uppercase font-semibold transition-all"
           style="background:#1C1917;color:#FAF8F5;font-family:'Inter',sans-serif;">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Mulai Konsultasi via WhatsApp
        </a>
        @endif
    </div>
</section>

@endsection

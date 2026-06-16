@extends('layouts.app')
@section('title', $settings->get('company_name', 'Waskita') . ' — ' . $settings->get('company_tagline', 'Premium Furniture'))

@section('content')
@php
    $waNumber = preg_replace('/[^0-9]/', '', $settings->get('company_whatsapp', ''));
    $waGeneral = $waNumber ? "https://wa.me/{$waNumber}?text=" . urlencode("Halo, saya ingin konsultasi mengenai produk furniture Anda.") : '#';
@endphp

{{-- ── HERO ─────────────────────────────────────────── --}}
@php $hasVideo = (bool)$settings->get('hero_video'); $hasImage = (bool)$settings->get('hero_image'); @endphp
<section id="hero-section" class="relative overflow-hidden" style="background:#100D0A;min-height:72vh;">

    {{-- ── Curtain --}}
    <div id="hero-curtain"></div>

    {{-- ── Gold particles --}}
    <div class="hero-particles" aria-hidden="true">
        @php $pData = [[8,0,6,'15px'],[17,1.2,8,'-12px'],[27,0.5,7,'10px'],[36,2.1,9,'-8px'],[45,0.8,6,'18px'],[53,1.7,8,'-15px'],[62,0.3,7,'6px'],[71,2.5,9,'-20px'],[80,1.0,6,'14px'],[89,1.8,8,'-10px'],[13,3.2,7,'8px'],[33,0.6,9,'-18px'],[57,2.8,6,'20px'],[75,1.4,8,'-6px'],[92,0.2,7,'12px'],[48,3.5,9,'-14px']]; @endphp
        @foreach($pData as $p)
        <span class="hp" style="left:{{ $p[0] }}%;--delay:{{ $p[1] }}s;--dur:{{ $p[2] }}s;--drift:{{ $p[3] }};--size:{{ ($loop->index % 3 === 0) ? '2px' : '1.5px' }};"></span>
        @endforeach
    </div>

    {{-- ── Ambient light bloom --}}
    <div class="hero-bloom" aria-hidden="true"></div>

    {{-- ── Media --}}
    @if($hasVideo)
    <video id="hero-video" muted loop playsinline preload="none"
           data-lazy-video="{{ Storage::url($settings->get('hero_video')) }}"
           @if($hasImage) poster="{{ Storage::url($settings->get('hero_image')) }}" @endif
           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;background:#100D0A;">
    </video>
    @elseif($hasImage)
    <div style="position:absolute;inset:0;z-index:0;">
        <img src="{{ Storage::url($settings->get('hero_image')) }}" alt=""
             style="width:100%;height:100%;object-fit:cover;">
    </div>
    @else
    {{-- Ambient warm wood background --}}
    <div style="position:absolute;inset:0;z-index:0;
        background:
            radial-gradient(ellipse 80% 60% at 50% 30%, rgba(101,62,20,0.45) 0%, transparent 70%),
            radial-gradient(ellipse 50% 40% at 20% 70%, rgba(184,150,90,0.1) 0%, transparent 60%),
            radial-gradient(ellipse 40% 50% at 80% 60%, rgba(184,150,90,0.08) 0%, transparent 60%),
            #100D0A;">
    </div>
    @endif

    {{-- ── Overlays --}}
    <div style="position:absolute;inset:0;z-index:1;background:rgba(12,9,6,0.62);pointer-events:none;"></div>
    <div style="position:absolute;inset:0;z-index:1;background:linear-gradient(to top,rgba(12,9,6,0.85) 0%,rgba(12,9,6,0.1) 45%,transparent 100%);pointer-events:none;"></div>
    <div style="position:absolute;top:0;left:0;right:0;height:140px;z-index:1;background:linear-gradient(to bottom,rgba(12,9,6,0.55) 0%,transparent 100%);pointer-events:none;"></div>

    {{-- ── Content --}}
    <div style="position:relative;z-index:10;min-height:72vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:4.5rem 1.5rem 3.5rem;text-align:center;">

        {{-- Top botanical label --}}
        <div class="h-label" style="margin-bottom:1.25rem;">
            {{-- Small Jepara leaf ornament --}}
            <svg width="140" height="18" viewBox="0 0 140 18" fill="none" style="display:block;margin:0 auto 0.5rem;">
                <path d="M70,9 C62,9 56,5 52,9 C56,13 62,13 70,9Z" fill="#B8965A" opacity="0.55"/>
                <path d="M70,9 C78,9 84,5 88,9 C84,13 78,13 70,9Z" fill="#B8965A" opacity="0.55"/>
                <path d="M52,9 C44,9 38,6 35,9 C38,12 44,12 52,9Z" fill="#B8965A" opacity="0.35"/>
                <path d="M88,9 C96,9 102,6 105,9 C102,12 96,12 88,9Z" fill="#B8965A" opacity="0.35"/>
                <line x1="0" y1="9" x2="32" y2="9" stroke="#B8965A" stroke-width="0.5" opacity="0.3"/>
                <line x1="108" y1="9" x2="140" y2="9" stroke="#B8965A" stroke-width="0.5" opacity="0.3"/>
                <circle cx="70" cy="9" r="1.5" fill="#B8965A" opacity="0.9"/>
            </svg>
            <span style="font-family:'Inter',sans-serif;font-size:0.6rem;letter-spacing:0.42em;text-transform:uppercase;font-weight:400;color:rgba(184,150,90,0.8);">
                {{ $settings->get('company_name', 'Waskita') }} &nbsp;&middot;&nbsp; Furniture Jepara
            </span>
        </div>

        {{-- Headline --}}
        <h1 id="hero-h1" style="font-family:'Playfair Display',serif;font-size:clamp(1.75rem,3.5vw,2.875rem);font-weight:600;line-height:1.18;color:#FAF8F5;margin:0;max-width:600px;">
            <div class="hero-line hero-line-1">
                <span class="line-inner" data-words>{{ $settings->get('hero_title', 'Ruang yang Bercerita,') }}</span>
            </div>
            <div class="hero-line hero-line-2" style="margin-top:0.1em;">
                <span class="line-inner" data-words data-gold style="color:#D4AF7A;font-style:italic;">
                    {{ $settings->get('company_tagline', 'Furnitur yang Menginspirasi.') }}
                </span>
            </div>
        </h1>

        {{-- Jepara ornamental divider (self-drawing) --}}
        <div class="h-ornament" style="margin:1.25rem auto;">
            <svg width="340" height="32" viewBox="0 0 340 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                {{-- Lines - draw animation --}}
                <line class="svg-draw" x1="0" y1="16" x2="118" y2="16" stroke="#B8965A" stroke-width="0.5" opacity="0.35" style="--len:118;--dly:1.45s"/>
                <line class="svg-draw" x1="222" y1="16" x2="340" y2="16" stroke="#B8965A" stroke-width="0.5" opacity="0.35" style="--len:118;--dly:1.45s"/>
                {{-- Left tendril --}}
                <path class="svg-draw" d="M118,16 Q124,16 127,11 Q130,7 134,9 Q137,11 135,14 Q133,17 129,16 Q124,16 118,16"
                      stroke="#B8965A" stroke-width="0.8" fill="none" opacity="0.7" style="--len:60;--dly:1.7s"/>
                {{-- Left leaves --}}
                <path class="svg-fade" d="M140,16 Q143,11 148,12 Q150,14 148,17 Q143,18 140,16Z" fill="#B8965A" opacity="0" style="--dly:1.9s;--op:0.45"/>
                <path class="svg-fade" d="M152,16 Q154,13 157,14 Q156,17 152,16Z" fill="#B8965A" opacity="0" style="--dly:2.0s;--op:0.3"/>
                {{-- Center medallion --}}
                <g transform="translate(170,16)">
                    <circle class="svg-draw" r="7" stroke="#B8965A" stroke-width="0.7" fill="none" opacity="0.5" style="--len:44;--dly:1.55s"/>
                    <path class="svg-fade" d="M0,-7 Q3,-3 0,0 Q-3,-3 0,-7Z" fill="#B8965A" opacity="0" style="--dly:1.85s;--op:0.4"/>
                    <path class="svg-fade" d="M0,7 Q3,3 0,0 Q-3,3 0,7Z" fill="#B8965A" opacity="0" style="--dly:1.88s;--op:0.4"/>
                    <path class="svg-fade" d="M-7,0 Q-3,3 0,0 Q-3,-3 -7,0Z" fill="#B8965A" opacity="0" style="--dly:1.91s;--op:0.4"/>
                    <path class="svg-fade" d="M7,0 Q3,3 0,0 Q3,-3 7,0Z" fill="#B8965A" opacity="0" style="--dly:1.94s;--op:0.4"/>
                    <circle class="svg-pulse" r="2.5" fill="#B8965A" opacity="0.85"/>
                </g>
                {{-- Right leaves --}}
                <path class="svg-fade" d="M188,16 Q186,13 183,14 Q184,17 188,16Z" fill="#B8965A" opacity="0" style="--dly:2.0s;--op:0.3"/>
                <path class="svg-fade" d="M200,16 Q197,11 192,12 Q190,14 192,17 Q197,18 200,16Z" fill="#B8965A" opacity="0" style="--dly:1.9s;--op:0.45"/>
                {{-- Right tendril --}}
                <path class="svg-draw" d="M222,16 Q216,16 213,11 Q210,7 206,9 Q203,11 205,14 Q207,17 211,16 Q216,16 222,16"
                      stroke="#B8965A" stroke-width="0.8" fill="none" opacity="0.7" style="--len:60;--dly:1.7s"/>
            </svg>
        </div>

        {{-- Subtitle --}}
        <p class="h-slide-1" style="font-family:'Inter',sans-serif;font-size:0.8125rem;line-height:1.8;color:rgba(250,248,245,0.52);font-weight:300;max-width:400px;margin:0 auto 1.625rem;letter-spacing:0.02em;">
            {{ $settings->get('hero_subtitle', 'Keahlian ukir Jepara yang diwariskan — menghadirkan furniture timeless untuk setiap sudut ruang Anda.') }}
        </p>

        {{-- CTAs --}}
        <div class="h-slide-2" style="display:flex;flex-wrap:wrap;gap:0.625rem;justify-content:center;margin-bottom:2rem;">
            <a href="{{ route('catalog.index') }}" class="hero-primary-btn"
               style="display:inline-flex;align-items:center;gap:0.65rem;padding:0.8rem 2rem;font-size:0.6rem;letter-spacing:0.28em;text-transform:uppercase;font-weight:600;background:#B8965A;color:#FAF8F5;font-family:'Inter',sans-serif;text-decoration:none;">
                Jelajahi Koleksi
                <svg class="hero-arrow" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"/>
                </svg>
            </a>
            @if($waNumber)
            <a href="{{ $waGeneral }}" target="_blank"
               style="display:inline-flex;align-items:center;padding:0.8rem 2rem;font-size:0.6rem;letter-spacing:0.28em;text-transform:uppercase;font-weight:600;border:1px solid rgba(250,248,245,0.2);color:rgba(250,248,245,0.7);font-family:'Inter',sans-serif;text-decoration:none;transition:border-color 0.3s,color 0.3s;">
                Konsultasi Gratis
            </a>
            @endif
        </div>

    </div>

    {{-- Video controls (desktop only — video itself doesn't load on mobile) --}}
    @if($hasVideo)
    <button id="video-toggle" class="hero-video-controls"
            style="position:absolute;bottom:1.75rem;right:1.75rem;z-index:20;width:36px;height:36px;border-radius:50%;border:1px solid rgba(250,248,245,0.18);background:rgba(12,9,6,0.5);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:border-color 0.3s;"
            aria-label="Pause/Play video">
        <svg id="icon-pause" style="width:11px;height:11px;color:#FAF8F5;" fill="currentColor" viewBox="0 0 24 24">
            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
        </svg>
        <svg id="icon-play" style="width:11px;height:11px;color:#FAF8F5;display:none;" fill="currentColor" viewBox="0 0 24 24">
            <path d="M8 5v14l11-7z"/>
        </svg>
    </button>
    <div class="hero-video-controls" style="position:absolute;bottom:0;left:0;right:0;height:2px;background:rgba(250,248,245,0.05);z-index:20;">
        <div id="video-progress" style="height:100%;width:0%;background:#B8965A;transition:width 0.5s linear;"></div>
    </div>
    @endif

    {{-- Scroll indicator --}}
    <div class="h-slide-3" style="position:absolute;bottom:2rem;left:50%;transform:translateX(-50%);display:flex;flex-direction:column;align-items:center;gap:0.4rem;z-index:15;">
        <span style="font-size:0.52rem;letter-spacing:0.3em;text-transform:uppercase;color:rgba(250,248,245,0.25);font-family:'Inter',sans-serif;">Scroll</span>
        <div style="width:1px;height:36px;overflow:hidden;position:relative;background:rgba(250,248,245,0.08);">
            <div style="position:absolute;inset:0;background:#B8965A;animation:scrollDot 1.8s ease-in-out 2.5s infinite;"></div>
        </div>
    </div>

</section>

<style>
/* ── Curtain ──────────────────────────────────────────── */
#hero-curtain {
    position:absolute;inset:0;z-index:100;background:#100D0A;
    transform-origin:top;
    animation:curtainReveal 1.1s cubic-bezier(0.77,0,0.175,1) 0.1s both;
    pointer-events:none;
}
@keyframes curtainReveal { 0%{transform:scaleY(1);} 100%{transform:scaleY(0);} }

/* ── Label + ornament fade --*/
.h-label {
    opacity:0;
    animation:hFade 1s ease 0.8s forwards;
}

/* ── Headline reveal ──────────────────────────────────── */
.hero-line { overflow:hidden; }
.hero-line .line-inner {
    display:block;
    transform:translateY(108%);
    opacity:0;
    animation:heroLineUp 1.1s cubic-bezier(0.16,1,0.3,1) both;
}
.hero-line-1 .line-inner { animation-delay:1.0s; }
.hero-line-2 .line-inner { animation-delay:1.18s; }
@keyframes heroLineUp { to { transform:translateY(0);opacity:1; } }

/* ── Ornament draw ────────────────────────────────────── */
.h-ornament {
    opacity:0;
    transform:scaleX(0.6);
    animation:hOrnament 1s cubic-bezier(0.16,1,0.3,1) 1.38s forwards;
}
@keyframes hOrnament { to { opacity:1;transform:scaleX(1); } }

/* ── Slide-up sequence ───────────────────────────────── */
.h-slide-1,.h-slide-2,.h-slide-3 {
    opacity:0;transform:translateY(22px);
    animation:hSlideUp 0.9s cubic-bezier(0.16,1,0.3,1) both;
}
.h-slide-1 { animation-delay:1.55s; }
.h-slide-2 { animation-delay:1.7s; }
.h-slide-3 { animation-delay:1.85s; }
@keyframes hSlideUp { to { opacity:1;transform:translateY(0); } }
@keyframes hFade    { to { opacity:1; } }

/* ── CTA ─────────────────────────────────────────────── */
.hero-primary-btn { transition:background 0.3s,opacity 0.3s; }
.hero-primary-btn:hover { opacity:0.88; }
.hero-primary-btn .hero-arrow { transition:transform 0.35s cubic-bezier(0.16,1,0.3,1); }
.hero-primary-btn:hover .hero-arrow { transform:translateX(5px); }

/* ── Video ────────────────────────────────────────────── */
#video-toggle:hover { border-color:rgba(184,150,90,0.65); }
/* Video itself is skipped on mobile to save bandwidth — hide its controls there too */
@media (max-width: 767px) {
    .hero-video-controls { display:none !important; }
}

/* ── Scroll dot ──────────────────────────────────────── */
@keyframes scrollDot { 0%{transform:translateY(-100%);} 100%{transform:translateY(100%);} }

/* ── Gold Particles ───────────────────────────────────── */
.hero-particles {
    position:absolute;inset:0;z-index:2;pointer-events:none;overflow:hidden;
}
.hp {
    position:absolute;
    bottom:-6px;
    width:var(--size, 1.5px);
    height:var(--size, 1.5px);
    border-radius:50%;
    background:radial-gradient(circle, #D4AF7A 0%, rgba(212,175,122,0.4) 60%, transparent 100%);
    opacity:0;
    animation:particleFloat var(--dur, 7s) ease-in-out var(--delay, 0s) infinite;
    will-change:transform,opacity;
}
@keyframes particleFloat {
    0%   { transform:translateY(0)           translateX(0)              scale(0);   opacity:0; }
    8%   { opacity:0.85; scale:1; }
    50%  { transform:translateY(-45vh)        translateX(var(--drift, 10px)); opacity:0.6; }
    85%  { opacity:0.15; }
    100% { transform:translateY(-85vh)        translateX(calc(var(--drift, 10px) * 1.6)); opacity:0; scale:0.5; }
}

/* ── Ambient bloom ────────────────────────────────────── */
.hero-bloom {
    position:absolute;
    top:50%; left:50%;
    transform:translate(-50%,-55%);
    width:min(600px, 90vw);
    height:min(400px, 60vh);
    border-radius:50%;
    background:radial-gradient(ellipse, rgba(184,150,90,0.07) 0%, transparent 70%);
    z-index:2;
    pointer-events:none;
    animation:bloomBreath 6s ease-in-out infinite;
    will-change:transform,opacity;
}
@keyframes bloomBreath {
    0%,100% { transform:translate(-50%,-55%) scale(1);   opacity:0.6; }
    50%      { transform:translate(-50%,-58%) scale(1.12); opacity:1;   }
}

/* ── SVG self-draw ────────────────────────────────────── */
.svg-draw {
    stroke-dasharray: var(--len, 120);
    stroke-dashoffset: var(--len, 120);
    animation: svgDraw 1.1s cubic-bezier(0.16,1,0.3,1) var(--dly, 1.4s) forwards;
}
@keyframes svgDraw { to { stroke-dashoffset: 0; } }

.svg-fade {
    animation: svgFadeIn 0.5s ease var(--dly, 1.8s) forwards;
}
@keyframes svgFadeIn { to { opacity: var(--op, 0.4); } }

.svg-pulse {
    animation: svgPulse 2.4s ease-in-out 2.1s infinite;
    transform-origin: center;
    transform-box: fill-box;
}
@keyframes svgPulse {
    0%,100% { r:2.5; opacity:0.85; }
    50%      { r:3.5; opacity:0.5;  }
}

/* ── Word-by-word stagger ─────────────────────────────── */
.hw {
    display:inline-block;
    opacity:0;
    transform:translateY(28px) rotate(2deg);
    animation:hwIn 0.75s cubic-bezier(0.16,1,0.3,1) var(--hw-delay, 0s) forwards;
}
@keyframes hwIn {
    to { opacity:1; transform:translateY(0) rotate(0deg); }
}

/* ── Label shimmer ────────────────────────────────────── */
.h-label span {
    position:relative;
    display:inline-block;
    overflow:hidden;
}
.h-label span::after {
    content:'';
    position:absolute;
    top:0; left:-100%; width:60%; height:100%;
    background:linear-gradient(90deg, transparent, rgba(212,175,122,0.45), transparent);
    animation:shimmerSweep 2.2s ease 2.5s forwards;
}
@keyframes shimmerSweep {
    0%   { left:-60%; opacity:1; }
    100% { left:120%; opacity:0; }
}
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
                         loading="lazy" decoding="async"
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
                             loading="lazy" decoding="async"
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
                             alt="About" loading="lazy" decoding="async" class="w-full h-full object-cover">
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

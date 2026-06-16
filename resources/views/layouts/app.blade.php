<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $settings->get('company_name', 'Waskita'))</title>
    <meta name="description" content="@yield('description', $settings->get('company_tagline', ''))">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream text-charcoal antialiased" style="background-color:#FAF8F5;color:#1C1917;">

{{-- ── Navbar ──────────────────────────────────────── --}}
<header id="main-navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">
        <div class="flex items-center justify-between h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
                @if($settings->get('company_logo'))
                    <img src="{{ Storage::url($settings->get('company_logo')) }}"
                         alt="{{ $settings->get('company_name') }}" class="h-9 w-auto">
                @else
                    <span style="font-family:'Playfair Display',serif;font-size:1.375rem;font-weight:600;letter-spacing:0.04em;color:#1C1917;">
                        {{ $settings->get('company_name', 'Waskita') }}
                    </span>
                @endif
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-10">
                <a href="{{ route('home') }}"
                   class="nav-link text-sm tracking-widest uppercase font-medium {{ request()->routeIs('home') ? 'active' : '' }}"
                   style="color:#44403C;font-family:'Inter',sans-serif;">Beranda</a>
                <a href="{{ route('catalog.index') }}"
                   class="nav-link text-sm tracking-widest uppercase font-medium {{ request()->routeIs('catalog.*') ? 'active' : '' }}"
                   style="color:#44403C;font-family:'Inter',sans-serif;">Katalog</a>
                <a href="{{ route('about') }}"
                   class="nav-link text-sm tracking-widest uppercase font-medium {{ request()->routeIs('about') ? 'active' : '' }}"
                   style="color:#44403C;font-family:'Inter',sans-serif;">Tentang</a>
                <a href="{{ route('contact.index') }}"
                   class="nav-link text-sm tracking-widest uppercase font-medium {{ request()->routeIs('contact.*') ? 'active' : '' }}"
                   style="color:#44403C;font-family:'Inter',sans-serif;">Kontak</a>
            </nav>

            {{-- CTA --}}
            @php $waNum = preg_replace('/[^0-9]/', '', $settings->get('company_whatsapp', '')); @endphp
            <div class="hidden md:flex items-center gap-4">
                @if($waNum)
                <a href="https://wa.me/{{ $waNum }}" target="_blank"
                   class="flex items-center gap-2 px-5 py-2.5 text-xs tracking-widest uppercase font-semibold border transition-all duration-300"
                   style="border-color:#1C1917;color:#1C1917;font-family:'Inter',sans-serif;">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Order via WA
                </a>
                @endif
            </div>

            {{-- Mobile toggle --}}
            <button id="mobile-menu-btn" class="md:hidden p-2 -mr-2" aria-label="Menu" style="color:#1C1917;">
                <svg class="icon-open w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
                </svg>
                <svg class="icon-close w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" style="background:rgba(250,248,245,0.98);backdrop-filter:blur(12px);border-top:1px solid #E5DDD5;">
        <div class="max-w-7xl mx-auto px-5 py-6 flex flex-col gap-5">
            <a href="{{ route('home') }}" class="text-sm tracking-widest uppercase font-medium" style="color:#44403C;">Beranda</a>
            <a href="{{ route('catalog.index') }}" class="text-sm tracking-widest uppercase font-medium" style="color:#44403C;">Katalog</a>
            <a href="{{ route('about') }}" class="text-sm tracking-widest uppercase font-medium" style="color:#44403C;">Tentang</a>
            <a href="{{ route('contact.index') }}" class="text-sm tracking-widest uppercase font-medium" style="color:#44403C;">Kontak</a>
            @if($waNum)
            <a href="https://wa.me/{{ $waNum }}" target="_blank"
               class="inline-flex items-center gap-2 px-5 py-3 text-xs tracking-widest uppercase font-semibold self-start"
               style="background:#1C1917;color:#FAF8F5;">
                Order via WhatsApp
            </a>
            @endif
        </div>
    </div>
</header>

{{-- Flash message --}}
@if(session('success'))
<div class="fixed bottom-6 right-6 z-50 max-w-sm px-5 py-4 text-sm shadow-xl"
     style="background:#1C1917;color:#FAF8F5;border-left:3px solid #B8965A;"
     x-data="{ show: true }" x-show="show">
    ✓ &nbsp;{{ session('success') }}
</div>
@endif

<main class="pt-20">
    @yield('content')
</main>

{{-- ── Footer ──────────────────────────────────────── --}}
<footer style="background:#1C1917;color:#A8A29E;" class="mt-0">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 pt-16 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12" style="border-bottom:1px solid #292524;">

            {{-- Brand --}}
            <div class="md:col-span-2">
                <div style="font-family:'Playfair Display',serif;font-size:1.75rem;font-weight:600;color:#FAF8F5;margin-bottom:1rem;letter-spacing:0.02em;">
                    {{ $settings->get('company_name', 'Waskita') }}
                </div>
                <p class="text-sm leading-relaxed" style="color:#A8A29E;max-width:340px;">
                    {{ $settings->get('company_tagline', 'Premium furniture untuk setiap sudut ruang Anda.') }}
                </p>
                @if($settings->get('company_whatsapp'))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->get('company_whatsapp')) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2.5 mt-6 px-5 py-3 text-xs tracking-widest uppercase font-semibold transition-all"
                   style="background:#B8965A;color:#FAF8F5;">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Konsultasi Sekarang
                </a>
                @endif
            </div>

            {{-- Navigation --}}
            <div>
                <h4 class="text-xs tracking-widest uppercase font-semibold mb-5" style="color:#FAF8F5;">Menu</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-cream transition" style="color:#A8A29E;">Beranda</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-cream transition" style="color:#A8A29E;">Tentang Kami</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-cream transition" style="color:#A8A29E;">Katalog</a></li>
                    <li><a href="{{ route('contact.index') }}" class="hover:text-cream transition" style="color:#A8A29E;">Kontak</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-xs tracking-widest uppercase font-semibold mb-5" style="color:#FAF8F5;">Kontak</h4>
                <ul class="space-y-3 text-sm" style="color:#A8A29E;">
                    @if($settings->get('company_address'))
                    <li class="leading-relaxed">{{ $settings->get('company_address') }}</li>
                    @endif
                    @if($settings->get('company_phone'))
                    <li>{{ $settings->get('company_phone') }}</li>
                    @endif
                    @if($settings->get('company_email'))
                    <li><a href="mailto:{{ $settings->get('company_email') }}" class="hover:text-cream transition">{{ $settings->get('company_email') }}</a></li>
                    @endif
                </ul>
                @if($settings->get('company_instagram') || $settings->get('company_facebook'))
                <div class="flex gap-4 mt-5">
                    @if($settings->get('company_instagram'))
                    <a href="{{ $settings->get('company_instagram') }}" target="_blank"
                       class="text-xs tracking-widest uppercase hover:text-cream transition" style="color:#A8A29E;">Instagram</a>
                    @endif
                    @if($settings->get('company_facebook'))
                    <a href="{{ $settings->get('company_facebook') }}" target="_blank"
                       class="text-xs tracking-widest uppercase hover:text-cream transition" style="color:#A8A29E;">Facebook</a>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs" style="color:#57534E;">
            <p>&copy; {{ date('Y') }} {{ $settings->get('company_name', 'Waskita') }}. All rights reserved.</p>
            <p style="color:#B8965A;">Premium Furniture</p>
        </div>
    </div>
</footer>

</body>
</html>

@extends('layouts.app')
@section('title', 'Tentang Kami — ' . $settings->get('company_name', 'Waskita'))

@section('content')
@php
    $waNumber = preg_replace('/[^0-9]/', '', $settings->get('company_whatsapp', ''));
    $waGeneral = $waNumber ? "https://wa.me/{$waNumber}?text=" . urlencode("Halo, saya ingin konsultasi mengenai produk furniture Anda.") : '#';
@endphp

{{-- ── Page Header ──────────────────────────────────── --}}
<section class="py-24 text-center" style="background:#EDE8DF;">
    <div class="max-w-3xl mx-auto px-5">
        <div data-animate class="deco-rule justify-center mb-6">Mengenal Kami</div>
        <h1 data-animate data-delay="100"
            style="font-family:'Playfair Display',serif;font-size:clamp(2rem,4vw,3rem);font-weight:600;color:#1C1917;line-height:1.2;">
            Tentang <em style="color:#B8965A;">{{ $settings->get('company_name', 'Waskita') }}</em>
        </h1>
        <p data-animate data-delay="200" class="mt-5 text-base leading-relaxed"
           style="color:#78716C;font-family:'Inter',sans-serif;font-weight:300;max-width:480px;margin-left:auto;margin-right:auto;">
            {{ $settings->get('company_tagline', 'Premium furniture untuk setiap sudut ruang Anda.') }}
        </p>
    </div>
</section>

{{-- ── Story Section ────────────────────────────────── --}}
@if($settings->get('company_about'))
<section class="py-24" style="background:#FAF8F5;">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

            {{-- Text --}}
            <div>
                <div data-animate class="deco-rule mb-6">Kisah Kami</div>
                <h2 data-animate data-delay="100"
                    style="font-family:'Playfair Display',serif;font-size:clamp(1.75rem,3vw,2.25rem);font-weight:600;color:#1C1917;margin-bottom:1.5rem;line-height:1.2;">
                    Dibuat dengan Passion,<br><em>Demi Ruang yang Bermakna</em>
                </h2>
                <div data-animate data-delay="200" class="space-y-4 leading-relaxed"
                     style="color:#78716C;font-family:'Inter',sans-serif;font-weight:300;font-size:1rem;">
                    @foreach(explode("\n", $settings->get('company_about')) as $paragraph)
                        @if(trim($paragraph))
                        <p>{{ trim($paragraph) }}</p>
                        @endif
                    @endforeach
                </div>
                @if($waNumber)
                <div data-animate data-delay="300" class="mt-10">
                    <a href="{{ $waGeneral }}" target="_blank"
                       class="inline-flex items-center gap-3 px-7 py-4 text-xs tracking-widest uppercase font-semibold transition"
                       style="background:#1C1917;color:#FAF8F5;font-family:'Inter',sans-serif;">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Konsultasi via WhatsApp
                    </a>
                </div>
                @endif
            </div>

            {{-- Decorative values --}}
            <div data-animate data-delay="150" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php $values = [
                    ['Kualitas', 'Kami hanya menggunakan material premium pilihan untuk setiap produk yang kami buat.'],
                    ['Desain', 'Setiap detail dirancang dengan penuh perhatian untuk menciptakan harmoni estetika.'],
                    ['Keahlian', 'Pengrajin berpengalaman dengan keahlian turun-temurun mengerjakan setiap produk.'],
                    ['Kepercayaan', 'Lebih dari satu dekade kami menjaga kepercayaan ribuan pelanggan setia.'],
                ]; @endphp
                @foreach($values as $i => $value)
                <div style="background:#EDE8DF;padding:1.75rem;">
                    <div class="w-8 h-px mb-4" style="background:#B8965A;"></div>
                    <h4 style="font-family:'Playfair Display',serif;font-size:1.125rem;font-weight:500;color:#1C1917;margin-bottom:0.625rem;">
                        {{ $value[0] }}
                    </h4>
                    <p class="text-sm leading-relaxed" style="color:#78716C;font-family:'Inter',sans-serif;font-weight:300;">
                        {{ $value[1] }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ── Contact Info ─────────────────────────────────── --}}
@if($settings->get('company_address') || $settings->get('company_phone') || $settings->get('company_email') || $settings->get('company_whatsapp'))
<section class="py-20" style="background:#1C1917;">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">
        <div class="text-center mb-14">
            <div data-animate class="deco-rule justify-center mb-5" style="color:#B8965A;">Info</div>
            <h2 data-animate data-delay="100"
                style="font-family:'Playfair Display',serif;font-size:clamp(1.5rem,3vw,2rem);font-weight:600;color:#FAF8F5;">
                Temukan Kami
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @if($settings->get('company_address'))
            <div data-animate style="background:#292524;padding:2rem;">
                <div class="w-10 h-10 flex items-center justify-center mb-5" style="border:1px solid #B8965A;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#B8965A;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                </div>
                <p class="text-xs tracking-widest uppercase mb-2" style="color:#B8965A;font-family:'Inter',sans-serif;">Alamat</p>
                <p class="text-sm leading-relaxed" style="color:#A8A29E;font-family:'Inter',sans-serif;">
                    {{ $settings->get('company_address') }}
                </p>
            </div>
            @endif

            @if($settings->get('company_phone'))
            <div data-animate data-delay="80" style="background:#292524;padding:2rem;">
                <div class="w-10 h-10 flex items-center justify-center mb-5" style="border:1px solid #B8965A;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#B8965A;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                    </svg>
                </div>
                <p class="text-xs tracking-widest uppercase mb-2" style="color:#B8965A;font-family:'Inter',sans-serif;">Telepon</p>
                <p class="text-sm" style="color:#A8A29E;font-family:'Inter',sans-serif;">{{ $settings->get('company_phone') }}</p>
            </div>
            @endif

            @if($settings->get('company_email'))
            <div data-animate data-delay="160" style="background:#292524;padding:2rem;">
                <div class="w-10 h-10 flex items-center justify-center mb-5" style="border:1px solid #B8965A;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#B8965A;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                </div>
                <p class="text-xs tracking-widest uppercase mb-2" style="color:#B8965A;font-family:'Inter',sans-serif;">Email</p>
                <a href="mailto:{{ $settings->get('company_email') }}"
                   class="text-sm transition" style="color:#A8A29E;font-family:'Inter',sans-serif;"
                   onmouseover="this.style.color='#FAF8F5'" onmouseout="this.style.color='#A8A29E'">
                    {{ $settings->get('company_email') }}
                </a>
            </div>
            @endif

            @if($settings->get('company_whatsapp') && $waNumber)
            <div data-animate data-delay="240" style="background:#292524;padding:2rem;">
                <div class="w-10 h-10 flex items-center justify-center mb-5" style="border:1px solid #B8965A;">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" style="color:#B8965A;">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </div>
                <p class="text-xs tracking-widest uppercase mb-2" style="color:#B8965A;font-family:'Inter',sans-serif;">WhatsApp</p>
                <a href="{{ $waGeneral }}" target="_blank"
                   class="text-sm transition" style="color:#A8A29E;font-family:'Inter',sans-serif;"
                   onmouseover="this.style.color='#FAF8F5'" onmouseout="this.style.color='#A8A29E'">
                    {{ $settings->get('company_whatsapp') }}
                </a>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- ── CTA ───────────────────────────────────────────── --}}
<section class="py-20 text-center" style="background:#FAF8F5;">
    <div class="max-w-xl mx-auto px-5">
        <h2 data-animate style="font-family:'Playfair Display',serif;font-size:clamp(1.5rem,3vw,2rem);font-weight:600;color:#1C1917;margin-bottom:1rem;">
            Siap Merancang Ruang Impian?
        </h2>
        <p data-animate data-delay="100" class="text-sm mb-8 leading-relaxed"
           style="color:#78716C;font-family:'Inter',sans-serif;font-weight:300;">
            Jelajahi koleksi lengkap kami atau hubungi tim kami untuk konsultasi personal.
        </p>
        <div data-animate data-delay="200" class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('catalog.index') }}"
               class="inline-flex items-center gap-2 px-7 py-4 text-xs tracking-widest uppercase font-semibold transition"
               style="background:#1C1917;color:#FAF8F5;font-family:'Inter',sans-serif;">
                Lihat Katalog
            </a>
            @if($waNumber)
            <a href="{{ $waGeneral }}" target="_blank"
               class="inline-flex items-center gap-2 px-7 py-4 text-xs tracking-widest uppercase font-semibold border transition"
               style="border-color:#B8965A;color:#B8965A;font-family:'Inter',sans-serif;">
                Hubungi Kami
            </a>
            @endif
        </div>
    </div>
</section>

@endsection

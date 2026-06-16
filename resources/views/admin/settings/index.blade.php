@extends('admin.layouts.app')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Website')

@section('content')

{{-- Validation errors --}}
@if($errors->any())
<div style="margin-bottom:20px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;padding:14px 16px;display:flex;align-items:flex-start;gap:10px">
    <svg width="18" height="18" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <div>
        <p style="font-size:13px;font-weight:600;color:#dc2626;margin:0 0 4px">Gagal menyimpan:</p>
        @foreach($errors->all() as $err)
            <p style="font-size:13px;color:#dc2626;margin:2px 0">• {{ $err }}</p>
        @endforeach
    </div>
</div>
@endif

{{-- ===== MEDIA SECTION (AJAX upload, independent dari form text) ===== --}}
<div class="ac" style="overflow:hidden;margin-bottom:20px">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px">
        <div style="width:28px;height:28px;border-radius:8px;background:#ede9fe;display:flex;align-items:center;justify-content:center">
            <svg width="14" height="14" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4"/></svg>
        </div>
        <div>
            <h2 style="font-size:13.5px;font-weight:600;color:#334155;margin:0">Upload Media</h2>
            <p style="font-size:11px;color:#94a3b8;margin:0">Video & gambar diupload langsung — tidak perlu klik Simpan</p>
        </div>
    </div>
    <div style="padding:20px;display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px">
        <div>
            <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 10px">Hero</p>
            <div style="display:flex;flex-direction:column;gap:16px">
                <x-admin.file-upload name="hero_video" label="Video Hero"
                    accept="video/mp4,video/webm,video/ogg"
                    :current="$settings['hero_video']" type="video" />
                <x-admin.file-upload name="hero_image" label="Gambar Hero (fallback)"
                    accept="image/*"
                    :current="$settings['hero_image']" type="image" />
            </div>
        </div>
        <div>
            <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 10px">Tentang Kami</p>
            <div style="display:flex;flex-direction:column;gap:16px">
                <x-admin.file-upload name="about_video" label="Video Tentang Kami"
                    accept="video/mp4,video/webm,video/ogg"
                    :current="$settings['about_video']" type="video" />
                <x-admin.file-upload name="about_image" label="Gambar Tentang Kami (fallback)"
                    accept="image/*"
                    :current="$settings['about_image']" type="image" />
            </div>
        </div>
        <div>
            <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 10px">Halaman Katalog</p>
            <div style="display:flex;flex-direction:column;gap:16px">
                <x-admin.file-upload name="catalog_video" label="Video Header Katalog"
                    accept="video/mp4,video/webm,video/ogg"
                    :current="$settings['catalog_video']" type="video" />
                <x-admin.file-upload name="catalog_image" label="Gambar Header Katalog (fallback)"
                    accept="image/*"
                    :current="$settings['catalog_image']" type="image" />
            </div>
        </div>
        <div>
            <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 10px">Halaman Kontak</p>
            <div style="display:flex;flex-direction:column;gap:16px">
                <x-admin.file-upload name="contact_video" label="Video Header Kontak"
                    accept="video/mp4,video/webm,video/ogg"
                    :current="$settings['contact_video']" type="video" />
                <x-admin.file-upload name="contact_image" label="Gambar Header Kontak (fallback)"
                    accept="image/*"
                    :current="$settings['contact_image']" type="image" />
            </div>
        </div>
        <div>
            <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 10px">Branding</p>
            <x-admin.file-upload name="company_logo" label="Logo Perusahaan"
                accept="image/*"
                :current="$settings['company_logo']" type="image" />
        </div>
    </div>
</div>

{{-- ===== TEXT SETTINGS FORM ===== --}}
<form method="POST" action="{{ route('panel.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Hero Text --}}
    <div class="ac" style="overflow:hidden;margin-bottom:16px">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px">
            <div style="width:28px;height:28px;border-radius:8px;background:#dbeafe;display:flex;align-items:center;justify-content:center">
                <svg width="14" height="14" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <h2 style="font-size:13.5px;font-weight:600;color:#334155;margin:0">Teks Hero</h2>
        </div>
        <div style="padding:20px;display:grid;grid-template-columns:repeat(2,1fr);gap:14px">
            <x-admin.input name="hero_title"    label="Judul Hero"    :value="$settings['hero_title']" />
            <x-admin.input name="hero_subtitle" label="Subtitle Hero" :value="$settings['hero_subtitle']" />
        </div>
    </div>

    {{-- Identitas --}}
    <div class="ac" style="overflow:hidden;margin-bottom:16px">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px">
            <div style="width:28px;height:28px;border-radius:8px;background:#fef3c7;display:flex;align-items:center;justify-content:center">
                <svg width="14" height="14" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h2 style="font-size:13.5px;font-weight:600;color:#334155;margin:0">Identitas Perusahaan</h2>
        </div>
        <div style="padding:20px;display:grid;grid-template-columns:repeat(2,1fr);gap:14px">
            <x-admin.input name="company_name"    label="Nama Perusahaan" :value="$settings['company_name']" required />
            <x-admin.input name="company_tagline" label="Tagline"         :value="$settings['company_tagline']" />
            <div style="grid-column:1/-1">
                <x-admin.textarea name="company_about"   label="Tentang Perusahaan" :value="$settings['company_about']"   rows="4" />
            </div>
            <div style="grid-column:1/-1">
                <x-admin.textarea name="company_address" label="Alamat"             :value="$settings['company_address']" rows="2" />
            </div>
            <x-admin.input name="company_phone"     label="Telepon"      :value="$settings['company_phone']" />
            <x-admin.input name="company_email"     label="Email"        :value="$settings['company_email']"     type="email" />
            <x-admin.input name="company_whatsapp"  label="WhatsApp"     :value="$settings['company_whatsapp']" />
            <x-admin.input name="company_instagram" label="Instagram URL" :value="$settings['company_instagram']" />
            <x-admin.input name="company_facebook"  label="Facebook URL"  :value="$settings['company_facebook']" />
        </div>
    </div>

    {{-- Save button --}}
    <div style="display:flex;justify-content:flex-end">
        <button type="submit" class="btn-amber" style="padding:10px 28px;font-size:13.5px">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            Simpan Pengaturan
        </button>
    </div>
</form>

<style>
@media (max-width: 640px) {
    .ac > div > div[style*="grid-template-columns:repeat(2"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection

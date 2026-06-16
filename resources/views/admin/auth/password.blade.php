@extends('admin.layouts.app')
@section('title', 'Ganti Password')
@section('page-title', 'Ganti Password')

@section('content')
<div style="max-width:480px">

    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.04)">

        {{-- Header --}}
        <div style="padding:20px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:12px">
            <div style="width:36px;height:36px;border-radius:10px;background:#fffbeb;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
            </div>
            <div>
                <p style="font-size:14px;font-weight:700;color:#1e293b;margin:0">Ganti Password</p>
                <p style="font-size:12px;color:#94a3b8;margin:0">Akun: {{ Auth::user()->email }}</p>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('panel.password.update') }}"
              style="padding:24px" x-data="{ saving: false }" @submit="saving = true">
            @csrf
            @method('PUT')

            <div style="display:flex;flex-direction:column;gap:18px">

                {{-- Current password --}}
                <div x-data="{ show: false }">
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">
                        Password Saat Ini
                    </label>
                    <div style="position:relative">
                        <input :type="show ? 'text' : 'password'" name="current_password"
                               class="ai"
                               style="padding-right:42px"
                               placeholder="Masukkan password lama"
                               autocomplete="current-password">
                        <button type="button" @click="show=!show"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:2px;display:flex">
                            <svg x-show="!show" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p style="font-size:12px;color:#ef4444;margin-top:5px;display:flex;align-items:center;gap:4px">
                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Divider --}}
                <div style="border-top:1px solid #f1f5f9"></div>

                {{-- New password --}}
                <div x-data="{ show: false }">
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">
                        Password Baru <span style="color:#ef4444">*</span>
                    </label>
                    <div style="position:relative">
                        <input :type="show ? 'text' : 'password'" name="password"
                               class="ai" style="padding-right:42px"
                               placeholder="Minimal 8 karakter"
                               autocomplete="new-password">
                        <button type="button" @click="show=!show"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:2px;display:flex">
                            <svg x-show="!show" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p style="font-size:12px;color:#ef4444;margin-top:5px">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm password --}}
                <div x-data="{ show: false }">
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">
                        Konfirmasi Password Baru <span style="color:#ef4444">*</span>
                    </label>
                    <div style="position:relative">
                        <input :type="show ? 'text' : 'password'" name="password_confirmation"
                               class="ai" style="padding-right:42px"
                               placeholder="Ulangi password baru"
                               autocomplete="new-password">
                        <button type="button" @click="show=!show"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:2px;display:flex">
                            <svg x-show="!show" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" :disabled="saving" class="btn-amber"
                        style="justify-content:center;padding:11px 24px;border-radius:10px;font-size:14px">
                    <svg x-show="saving" width="16" height="16" fill="none" viewBox="0 0 24 24" style="animation:spin 1s linear infinite">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity=".25"/>
                        <path fill="currentColor" opacity=".75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <svg x-show="!saving" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span x-text="saving ? 'Menyimpan...' : 'Simpan Password Baru'"></span>
                </button>
            </div>
        </form>
    </div>

    <p style="margin-top:16px;font-size:12px;color:#94a3b8;display:flex;align-items:center;gap:6px">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Setelah ganti password, Anda akan tetap login. Gunakan password baru saat login berikutnya.
    </p>
</div>

<style>
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection

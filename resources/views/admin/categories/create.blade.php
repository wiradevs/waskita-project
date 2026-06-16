@extends('admin.layouts.app')
@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('panel.categories.store') }}" enctype="multipart/form-data"
          x-data="{ saving: false }" @submit="saving = true">
        @csrf
        <div class="card p-6 space-y-5">
            <h3 class="font-semibold text-stone-700 text-sm border-b border-stone-100 pb-3">Informasi Kategori</h3>
            <x-admin.input name="name" label="Nama Kategori" required />
            <x-admin.textarea name="description" label="Deskripsi" rows="3" />
            <x-admin.file-upload name="image" label="Gambar Kategori" accept="image/*" type="image" />

            <label class="flex items-center justify-between cursor-pointer py-1">
                <span class="text-sm text-stone-600">Kategori Aktif</span>
                <div x-data="{ on: true }">
                    <input type="hidden" name="is_active" :value="on ? '1' : '0'">
                    <button type="button" @click="on = !on"
                            :class="on ? 'bg-amber-500' : 'bg-stone-200'"
                            class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors duration-200">
                        <span :class="on ? 'translate-x-5' : 'translate-x-1'"
                              class="inline-block h-3.5 w-3.5 transform rounded-full bg-white shadow transition-transform duration-200"></span>
                    </button>
                </div>
            </label>

            <x-admin.input name="sort_order" label="Urutan tampil" value="0" type="number" />
        </div>

        <div class="flex gap-2.5 mt-4">
            <button type="submit" :disabled="saving"
                    class="btn-primary flex items-center gap-2 px-8 py-3 rounded-xl font-semibold text-sm">
                <svg x-show="saving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <span x-text="saving ? 'Menyimpan...' : 'Simpan'"></span>
            </button>
            <a href="{{ route('panel.categories.index') }}"
               style="border:1.5px solid #e2ddd7;border-radius:12px;padding:12px 24px;font-size:14px;color:#57534e;transition:background .15s;"
               onmouseover="this.style.background='#f5f3f0'" onmouseout="this.style.background='transparent'">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

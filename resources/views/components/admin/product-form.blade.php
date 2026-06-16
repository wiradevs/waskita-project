@props(['product' => null, 'categories'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    {{-- Main --}}
    <div class="lg:col-span-2 space-y-5">
        <div class="card p-6 space-y-5">
            <h3 class="font-semibold text-stone-700 text-sm border-b border-stone-100 pb-3">Informasi Produk</h3>
            <x-admin.input name="name" label="Nama Produk" :value="$product?->name" required />
            <div>
                <label class="block text-sm font-medium text-stone-600 mb-1.5">Kategori</label>
                <select name="product_category_id"
                        style="border:1.5px solid #e2ddd7;border-radius:8px;background:#fdfcfb;padding:9px 12px;font-size:14px;color:#1c1917;width:100%;transition:border-color .15s,box-shadow .15s;"
                        onfocus="this.style.borderColor='#d97706';this.style.boxShadow='0 0 0 3px rgba(217,119,6,.1)'"
                        onblur="this.style.borderColor='#e2ddd7';this.style.boxShadow='none'">
                    <option value="">— Pilih Kategori —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('product_category_id', $product?->product_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-admin.textarea name="short_description" label="Deskripsi Singkat" :value="$product?->short_description" rows="2" />
            <x-admin.textarea name="description" label="Deskripsi Lengkap" :value="$product?->description" rows="6" />
        </div>

        <div class="card p-6 space-y-4">
            <h3 class="font-semibold text-stone-700 text-sm border-b border-stone-100 pb-3">Harga</h3>
            <div class="grid grid-cols-2 gap-4">
                <x-admin.input name="price" label="Harga (Rp)" :value="$product?->price" type="number" />
                <x-admin.input name="price_unit" label="Satuan (m², unit, dll)" :value="$product?->price_unit" />
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-5">
        <div class="card p-6 space-y-4">
            <h3 class="font-semibold text-stone-700 text-sm border-b border-stone-100 pb-3">Thumbnail</h3>
            <x-admin.file-upload name="thumbnail" label="Gambar Produk" accept="image/*"
                                  :current="$product?->thumbnail" type="image" />
        </div>

        <div class="card p-6 space-y-4">
            <h3 class="font-semibold text-stone-700 text-sm border-b border-stone-100 pb-3">Pengaturan</h3>

            <label class="flex items-center justify-between cursor-pointer py-1">
                <span class="text-sm text-stone-600">Produk Aktif</span>
                <div x-data="{ on: {{ old('is_active', $product?->is_active ?? true) ? 'true' : 'false' }} }">
                    <input type="hidden" name="is_active" :value="on ? '1' : '0'">
                    <button type="button" @click="on = !on"
                            :class="on ? 'bg-amber-500' : 'bg-stone-200'"
                            class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors duration-200 focus:outline-none">
                        <span :class="on ? 'translate-x-5' : 'translate-x-1'"
                              class="inline-block h-3.5 w-3.5 transform rounded-full bg-white shadow transition-transform duration-200"></span>
                    </button>
                </div>
            </label>

            <label class="flex items-center justify-between cursor-pointer py-1">
                <span class="text-sm text-stone-600">Tampilkan di Featured</span>
                <div x-data="{ on: {{ old('is_featured', $product?->is_featured ?? false) ? 'true' : 'false' }} }">
                    <input type="hidden" name="is_featured" :value="on ? '1' : '0'">
                    <button type="button" @click="on = !on"
                            :class="on ? 'bg-amber-500' : 'bg-stone-200'"
                            class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors duration-200 focus:outline-none">
                        <span :class="on ? 'translate-x-5' : 'translate-x-1'"
                              class="inline-block h-3.5 w-3.5 transform rounded-full bg-white shadow transition-transform duration-200"></span>
                    </button>
                </div>
            </label>

            <x-admin.input name="sort_order" label="Urutan tampil" :value="$product?->sort_order ?? 0" type="number" />
        </div>

        <div class="flex gap-2.5" x-data="{ saving: false }">
            <button type="submit" @click="saving = true" :disabled="saving"
                    class="btn-primary flex-1 flex items-center justify-center gap-2 py-3 rounded-xl font-semibold text-sm">
                <svg x-show="saving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <span x-text="saving ? 'Menyimpan...' : 'Simpan'"></span>
            </button>
            <a href="{{ route('panel.products.index') }}"
               style="border:1.5px solid #e2ddd7;border-radius:12px;padding:12px 16px;font-size:14px;color:#57534e;transition:background .15s;"
               onmouseover="this.style.background='#f5f3f0'" onmouseout="this.style.background='transparent'">
                Batal
            </a>
        </div>
    </div>
</div>

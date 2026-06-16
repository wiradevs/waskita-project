@props(['product' => null, 'categories'])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Main info --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h3 class="font-semibold text-gray-800">Informasi Produk</h3>

            <x-admin.input name="name" label="Nama Produk" :value="$product?->name" required />

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                <select name="product_category_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <option value="">— Pilih Kategori —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                                {{ old('product_category_id', $product?->product_category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <x-admin.textarea name="short_description" label="Deskripsi Singkat" :value="$product?->short_description" rows="2" />
            <x-admin.textarea name="description" label="Deskripsi Lengkap" :value="$product?->description" rows="5" />
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h3 class="font-semibold text-gray-800">Harga</h3>
            <div class="grid grid-cols-2 gap-4">
                <x-admin.input name="price" label="Harga (Rp)" :value="$product?->price" type="number" />
                <x-admin.input name="price_unit" label="Satuan (misal: m², unit)" :value="$product?->price_unit" />
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h3 class="font-semibold text-gray-800">Thumbnail</h3>
            <x-admin.file-upload name="thumbnail" label="Gambar Produk" accept="image/*"
                                  :current="$product?->thumbnail" type="image" />
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h3 class="font-semibold text-gray-800">Pengaturan</h3>

            <label class="flex items-center gap-3 cursor-pointer">
                <div class="relative" x-data="{ on: {{ old('is_active', $product?->is_active ?? true) ? 'true' : 'false' }} }">
                    <input type="hidden" name="is_active" :value="on ? '1' : '0'">
                    <button type="button" @click="on = !on"
                            :class="on ? 'bg-amber-500' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                        <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                              class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                    </button>
                </div>
                <span class="text-sm text-gray-700">Produk Aktif</span>
            </label>

            <label class="flex items-center gap-3 cursor-pointer">
                <div class="relative" x-data="{ on: {{ old('is_featured', $product?->is_featured ?? false) ? 'true' : 'false' }} }">
                    <input type="hidden" name="is_featured" :value="on ? '1' : '0'">
                    <button type="button" @click="on = !on"
                            :class="on ? 'bg-amber-500' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                        <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                              class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                    </button>
                </div>
                <span class="text-sm text-gray-700">Featured</span>
            </label>

            <x-admin.input name="sort_order" label="Urutan tampil" :value="$product?->sort_order ?? 0" type="number" />
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="flex-1 bg-amber-500 hover:bg-amber-400 text-white font-semibold py-3 rounded-lg transition-colors text-sm">
                Simpan
            </button>
            <a href="{{ route('panel.products.index') }}"
               class="px-4 py-3 border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition-colors text-center">
                Batal
            </a>
        </div>
    </div>
</div>

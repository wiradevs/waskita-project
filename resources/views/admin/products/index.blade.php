@extends('admin.layouts.app')
@section('title', 'Produk')
@section('page-title', 'Produk')

@section('content')
<div class="card overflow-hidden">
    {{-- Toolbar --}}
    <div class="px-5 py-4 border-b border-stone-100 flex flex-col sm:flex-row gap-3">
        <form class="flex gap-2 flex-1" method="GET">
            <div class="relative flex-1 max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                       style="border:1.5px solid #e2ddd7;border-radius:8px;padding:8px 12px 8px 36px;font-size:13px;width:100%;"
                       onfocus="this.style.borderColor='#d97706'" onblur="this.style.borderColor='#e2ddd7'">
            </div>
            <select name="category"
                    style="border:1.5px solid #e2ddd7;border-radius:8px;padding:8px 12px;font-size:13px;"
                    onfocus="this.style.borderColor='#d97706'" onblur="this.style.borderColor='#e2ddd7'">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit"
                    style="background:#f5f3f0;border:1.5px solid #e2ddd7;border-radius:8px;padding:8px 14px;font-size:13px;color:#57534e;transition:background .15s;"
                    onmouseover="this.style.background='#ece9e4'" onmouseout="this.style.background='#f5f3f0'">
                Cari
            </button>
        </form>
        <a href="{{ route('panel.products.create') }}"
           class="btn-primary flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </a>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-100">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Produk</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Harga</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-b border-stone-50 hover:bg-stone-50/80 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                @if($product->thumbnail)
                                    <img src="{{ Storage::url($product->thumbnail) }}"
                                         class="w-10 h-10 rounded-xl object-cover flex-shrink-0 border border-stone-100">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-stone-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4.5 h-4.5 w-5 h-5 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-medium text-stone-700 truncate">{{ $product->name }}</p>
                                    @if($product->short_description)
                                        <p class="text-xs text-stone-400 truncate max-w-[200px]">{{ $product->short_description }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="text-xs bg-stone-100 text-stone-600 px-2.5 py-1 rounded-lg font-medium">
                                {{ $product->category?->name ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-stone-600 text-xs">{{ $product->formatted_price ?? '—' }}</td>
                        <td class="px-4 py-3.5">
                            <div class="flex flex-col gap-1">
                                <span class="inline-flex items-center w-fit gap-1 px-2 py-0.5 rounded-lg text-xs font-medium
                                             {{ $product->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-stone-100 text-stone-400' }}">
                                    <span class="w-1 h-1 rounded-full {{ $product->is_active ? 'bg-emerald-500' : 'bg-stone-300' }}"></span>
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                @if($product->is_featured)
                                    <span class="inline-flex items-center w-fit px-2 py-0.5 rounded-lg text-xs font-medium bg-amber-50 text-amber-600">⭐ Featured</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('panel.products.edit', $product) }}"
                                   class="text-xs text-blue-600 hover:text-blue-700 font-medium hover:underline">Edit</a>
                                <form method="POST" action="{{ route('panel.products.destroy', $product) }}"
                                      onsubmit="return confirm('Hapus produk \'{{ addslashes($product->name) }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-500 hover:text-rose-600 font-medium hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-14 text-center">
                            <svg class="w-10 h-10 text-stone-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-stone-400 text-sm">Belum ada produk</p>
                            <a href="{{ route('panel.products.create') }}" class="text-amber-600 text-sm hover:underline mt-1 inline-block">+ Tambah produk pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="px-5 py-4 border-t border-stone-100">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection

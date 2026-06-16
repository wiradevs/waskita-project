@extends('admin.layouts.app')
@section('title', 'Kategori')
@section('page-title', 'Kategori Produk')

@section('content')
<div class="card overflow-hidden">
    <div class="px-5 py-4 border-b border-stone-100 flex items-center justify-between">
        <p class="text-sm text-stone-500"><span class="font-semibold text-stone-700">{{ $categories->count() }}</span> kategori</p>
        <a href="{{ route('panel.categories.create') }}"
           class="btn-primary flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kategori
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-100">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Produk</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Urutan</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr class="border-b border-stone-50 hover:bg-stone-50/80 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                @if($cat->image)
                                    <img src="{{ Storage::url($cat->image) }}"
                                         class="w-10 h-10 rounded-xl object-cover flex-shrink-0 border border-stone-100">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-stone-700">{{ $cat->name }}</p>
                                    <p class="text-xs text-stone-400 font-mono">{{ $cat->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="text-xs bg-stone-100 text-stone-600 px-2.5 py-1 rounded-lg font-medium">{{ $cat->products_count }} produk</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-medium
                                         {{ $cat->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-stone-100 text-stone-400' }}">
                                <span class="w-1 h-1 rounded-full {{ $cat->is_active ? 'bg-emerald-500' : 'bg-stone-300' }}"></span>
                                {{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-stone-400 text-xs">{{ $cat->sort_order }}</td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('panel.categories.edit', $cat) }}"
                                   class="text-xs text-blue-600 hover:text-blue-700 font-medium">Edit</a>
                                <form method="POST" action="{{ route('panel.categories.destroy', $cat) }}"
                                      onsubmit="return confirm('Hapus kategori \'{{ addslashes($cat->name) }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-500 hover:text-rose-600 font-medium">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <svg class="w-10 h-10 text-stone-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <p class="text-stone-400 text-sm">Belum ada kategori</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

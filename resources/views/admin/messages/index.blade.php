@extends('admin.layouts.app')
@section('title', 'Pesan Masuk')
@section('page-title', 'Pesan Masuk')

@section('content')
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-100">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Pengirim</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider hidden md:table-cell">Subjek</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider hidden sm:table-cell">Waktu</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-stone-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr class="border-b border-stone-50 hover:bg-stone-50/80 transition-colors {{ !$msg->is_read ? 'bg-amber-50/30' : '' }}">
                        <td class="px-5 py-3.5">
                            <a href="{{ route('panel.messages.show', $msg) }}" class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full {{ !$msg->is_read ? 'bg-amber-100 text-amber-700' : 'bg-stone-100 text-stone-500' }} flex items-center justify-center font-semibold text-sm flex-shrink-0">
                                    {{ substr($msg->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <p class="font-medium text-stone-700">{{ $msg->name }}</p>
                                        @if(!$msg->is_read)
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 flex-shrink-0"></span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-stone-400">{{ $msg->email }}</p>
                                </div>
                            </a>
                        </td>
                        <td class="px-4 py-3.5 text-stone-600 max-w-xs hidden md:table-cell">
                            <p class="truncate">{{ $msg->subject }}</p>
                        </td>
                        <td class="px-4 py-3.5 text-stone-400 text-xs whitespace-nowrap hidden sm:table-cell">
                            {{ $msg->created_at->format('d M Y') }}<br>
                            <span class="text-stone-300">{{ $msg->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('panel.messages.show', $msg) }}"
                                   class="text-xs text-blue-600 hover:text-blue-700 font-medium">Baca</a>
                                <form method="POST" action="{{ route('panel.messages.destroy', $msg) }}"
                                      onsubmit="return confirm('Hapus pesan dari {{ addslashes($msg->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-500 hover:text-rose-600 font-medium">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-16 text-center">
                            <svg class="w-10 h-10 text-stone-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-stone-400 text-sm">Belum ada pesan masuk</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($messages->hasPages())
        <div class="px-5 py-4 border-t border-stone-100">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection

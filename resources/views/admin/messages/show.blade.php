@extends('admin.layouts.app')
@section('title', 'Baca Pesan')
@section('page-title', 'Detail Pesan')

@section('content')
<div class="max-w-2xl">
    <div class="card overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-5 bg-stone-50/50 border-b border-stone-100">
            <h2 class="font-semibold text-stone-800 text-base mb-1">{{ $message->subject }}</h2>
            <p class="text-stone-400 text-xs">{{ $message->created_at->format('d F Y, H:i') }}</p>
        </div>

        {{-- Sender --}}
        <div class="px-6 py-4 border-b border-stone-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                    {{ substr($message->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-semibold text-stone-700">{{ $message->name }}</p>
                    <a href="mailto:{{ $message->email }}" class="text-amber-600 text-sm hover:underline">{{ $message->email }}</a>
                </div>
            </div>
            @if($message->phone)
                <div class="flex items-center gap-2 text-sm text-stone-500">
                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    {{ $message->phone }}
                </div>
            @endif
        </div>

        {{-- Body --}}
        <div class="px-6 py-5">
            <p class="text-stone-400 text-xs uppercase font-semibold tracking-wide mb-3">Pesan</p>
            <div class="text-stone-700 text-sm leading-relaxed whitespace-pre-wrap bg-stone-50 rounded-xl p-4 border border-stone-100">{{ $message->message }}</div>
        </div>

        {{-- Actions --}}
        <div class="px-6 py-4 border-t border-stone-100 flex flex-wrap gap-3">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}"
               class="btn-primary flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Balas via Email
            </a>
            <a href="{{ route('panel.messages.index') }}"
               style="border:1.5px solid #e2ddd7;border-radius:12px;padding:10px 20px;font-size:14px;color:#57534e;transition:background .15s;display:flex;align-items:center;gap:6px;"
               onmouseover="this.style.background='#f5f3f0'" onmouseout="this.style.background='transparent'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <form method="POST" action="{{ route('panel.messages.destroy', $message) }}"
                  class="ml-auto" onsubmit="return confirm('Hapus pesan ini?')">
                @csrf @method('DELETE')
                <button type="submit"
                        style="border:1.5px solid #fecaca;border-radius:12px;padding:10px 20px;font-size:14px;color:#ef4444;transition:background .15s;"
                        onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

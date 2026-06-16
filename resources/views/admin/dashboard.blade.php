@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Greeting bar --}}
<div style="margin-bottom:24px">
    <p style="font-size:22px;font-weight:700;color:#1e293b;margin:0 0 4px">
        Halo, {{ Auth::user()->name ?? 'Admin' }} 👋
    </p>
    <p style="font-size:13px;color:#64748b;margin:0">
        {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }} · Berikut ringkasan website Anda
    </p>
</div>

{{-- Stat cards --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px">

    @php
        $statCards = [
            [
                'label' => 'Total Produk',
                'value' => $stats['products'],
                'icon'  => 'M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16zM3.27 6.96L12 12.01l8.73-5.05M12 22.08V12',
                'color' => '#3b82f6', 'light' => '#eff6ff', 'link' => 'panel.products.index',
            ],
            [
                'label' => 'Kategori',
                'value' => $stats['categories'],
                'icon'  => 'M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82zM7 7h.01',
                'color' => '#8b5cf6', 'light' => '#f5f3ff', 'link' => 'panel.categories.index',
            ],
            [
                'label' => 'Total Pesan',
                'value' => $stats['messages'],
                'icon'  => 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zM22 6l-10 7L2 6',
                'color' => '#10b981', 'light' => '#ecfdf5', 'link' => 'panel.messages.index',
            ],
            [
                'label' => 'Belum Dibaca',
                'value' => $stats['unread_messages'],
                'icon'  => 'M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0',
                'color' => '#f59e0b', 'light' => '#fffbeb', 'link' => 'panel.messages.index',
            ],
        ];
    @endphp

    @foreach($statCards as $c)
    <a href="{{ route($c['link']) }}" style="text-decoration:none"
       x-data
       @mouseenter="$el.style.transform='translateY(-3px)';$el.style.boxShadow='0 8px 24px rgba(0,0,0,.1)'"
       @mouseleave="$el.style.transform='translateY(0)';$el.style.boxShadow='0 1px 4px rgba(0,0,0,.04)'">
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,.04);transition:transform .2s,box-shadow .2s;position:relative;overflow:hidden">
            {{-- top accent line --}}
            <div style="position:absolute;top:0;left:0;right:0;height:3px;background:{{ $c['color'] }};border-radius:14px 14px 0 0"></div>

            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-top:4px">
                <div>
                    <p style="font-size:11.5px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin:0 0 10px">{{ $c['label'] }}</p>
                    <p style="font-size:32px;font-weight:800;color:#1e293b;margin:0;line-height:1">{{ $c['value'] }}</p>
                </div>
                <div style="width:42px;height:42px;border-radius:12px;background:{{ $c['light'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg width="20" height="20" fill="none" stroke="{{ $c['color'] }}" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="{{ $c['icon'] }}"/>
                    </svg>
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div>

{{-- Bottom grid --}}
<div style="display:grid;grid-template-columns:1fr 1.6fr;gap:16px">

    {{-- Quick actions --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,.04)">
        <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0 0 14px">Aksi Cepat</p>
        <div style="display:flex;flex-direction:column;gap:8px">

            @php
                $actions = [
                    ['href'=>route('panel.products.create'),   'label'=>'Tambah Produk Baru',  'color'=>'#3b82f6','light'=>'#eff6ff','icon'=>'M12 5v14M5 12h14'],
                    ['href'=>route('panel.categories.create'), 'label'=>'Tambah Kategori',      'color'=>'#8b5cf6','light'=>'#f5f3ff','icon'=>'M12 5v14M5 12h14'],
                    ['href'=>route('panel.settings.index'),    'label'=>'Pengaturan Website',   'color'=>'#64748b','light'=>'#f1f5f9','icon'=>'M12 15a3 3 0 100-6 3 3 0 000 6zM19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z'],
                    ['href'=>route('panel.messages.index'),    'label'=>'Lihat Semua Pesan',    'color'=>'#10b981','light'=>'#ecfdf5','icon'=>'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zM22 6l-10 7L2 6'],
                ];
            @endphp

            @foreach($actions as $action)
            <a href="{{ $action['href'] }}"
               style="display:flex;align-items:center;gap:12px;padding:11px 14px;border-radius:10px;background:#f8fafc;text-decoration:none;color:#334155;font-size:13.5px;font-weight:500;transition:background .15s,transform .1s;border:1.5px solid transparent"
               onmouseover="this.style.background='{{ $action['light'] }}';this.style.color='{{ $action['color'] }}';this.style.borderColor='{{ $action['color'] }}22'"
               onmouseout="this.style.background='#f8fafc';this.style.color='#334155';this.style.borderColor='transparent'">
                <div style="width:32px;height:32px;border-radius:8px;background:{{ $action['light'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg width="15" height="15" fill="none" stroke="{{ $action['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="{{ $action['icon'] }}"/>
                    </svg>
                </div>
                {{ $action['label'] }}
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-left:auto;opacity:.4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Recent messages --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,.04)">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
            <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0">Pesan Terbaru</p>
            <a href="{{ route('panel.messages.index') }}"
               style="font-size:12px;font-weight:600;color:#d97706;text-decoration:none"
               onmouseover="this.style.textDecoration='underline'"
               onmouseout="this.style.textDecoration='none'">Lihat semua →</a>
        </div>

        <div>
            @forelse($recent_messages as $msg)
            <a href="{{ route('panel.messages.show', $msg) }}"
               style="display:flex;align-items:center;gap:12px;padding:10px 10px;margin:0 -10px;border-radius:10px;text-decoration:none;transition:background .15s;border-bottom:1px solid #f1f5f9"
               onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">

                <div style="width:36px;height:36px;border-radius:50%;background:{{ !$msg->is_read ? '#fef3c7' : '#f1f5f9' }};color:{{ !$msg->is_read ? '#92400e' : '#64748b' }};display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0">
                    {{ strtoupper(substr($msg->name, 0, 1)) }}
                </div>

                <div style="min-width:0;flex:1">
                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:2px">
                        <p style="font-size:13.5px;font-weight:600;color:#1e293b;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $msg->name }}</p>
                        @if(!$msg->is_read)
                            <span style="width:6px;height:6px;border-radius:50%;background:#ef4444;flex-shrink:0"></span>
                        @endif
                    </div>
                    <p style="font-size:12px;color:#94a3b8;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $msg->subject }}</p>
                </div>

                <p style="font-size:11.5px;color:#cbd5e1;flex-shrink:0;margin:0">{{ $msg->created_at->diffForHumans() }}</p>
            </a>
            @empty
            <div style="text-align:center;padding:40px 0">
                <div style="width:52px;height:52px;border-radius:14px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zM22 6l-10 7L2 6"/>
                    </svg>
                </div>
                <p style="font-size:13px;color:#94a3b8;margin:0">Belum ada pesan masuk</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

{{-- Responsive fix for bottom grid --}}
<style>
    @media(max-width:768px){
        .dash-grid { grid-template-columns: 1fr !important; }
    }
</style>
<script>
    document.querySelector('[style*="grid-template-columns:1fr 1.6fr"]')?.classList.add('dash-grid');
</script>

@endsection

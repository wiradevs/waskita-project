<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Waskita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            background: #f1f5f9;
            font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;
            color: #1e293b;
            margin: 0;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px;
            background: #1e293b;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 40;
            transition: transform .28s cubic-bezier(.4,0,.2,1);
        }
        .sidebar-brand {
            height: 64px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 20px;
            border-bottom: 1px solid rgba(255,255,255,.06);
            flex-shrink: 0;
        }
        .sidebar-icon-wrap {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(245,158,11,.35);
        }
        .sidebar-nav { flex: 1; padding: 12px 10px; overflow-y: auto; }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13.5px; font-weight: 500;
            color: #94a3b8;
            text-decoration: none;
            transition: background .15s, color .15s;
            margin-bottom: 2px;
            border: none; width: 100%;
            cursor: pointer; background: none;
            position: relative;
        }
        .nav-link:hover { background: rgba(255,255,255,.06); color: #e2e8f0; }
        .nav-link.active {
            background: rgba(245,158,11,.12);
            color: #fbbf24;
        }
        .nav-link.active .nav-icon { color: #f59e0b; }
        .nav-link .nav-badge {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: 10px; font-weight: 700;
            padding: 1px 6px;
            border-radius: 99px;
            line-height: 1.4;
        }
        .nav-icon { width: 18px; height: 18px; flex-shrink: 0; color: #64748b; transition: color .15s; }
        .sidebar-footer {
            padding: 10px;
            border-top: 1px solid rgba(255,255,255,.06);
            flex-shrink: 0;
        }
        .user-row {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px; border-radius: 8px;
            margin-bottom: 4px;
        }
        .user-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 12px; font-weight: 700;
            flex-shrink: 0;
        }

        /* ── Topbar ── */
        .topbar {
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center;
            padding: 0 24px;
            gap: 12px;
            position: sticky; top: 0; z-index: 20;
        }

        /* ── Cards ── */
        .ac { /* admin card */
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }

        /* ── Buttons ── */
        .btn-amber {
            display: inline-flex; align-items: center; gap: 6px;
            background: #d97706; color: #fff;
            border: none; cursor: pointer;
            font-weight: 600; font-size: 13.5px;
            padding: 9px 18px; border-radius: 10px;
            text-decoration: none;
            transition: background .15s, box-shadow .15s, transform .1s;
        }
        .btn-amber:hover { background: #b45309; box-shadow: 0 4px 14px rgba(217,119,6,.3); transform: translateY(-1px); }
        .btn-amber:active { transform: translateY(0); box-shadow: none; }

        /* ── Form inputs ── */
        .ai { /* admin input */
            width: 100%;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 13.5px;
            color: #1e293b;
            background: #f8fafc;
            transition: border-color .15s, box-shadow .15s;
            outline: none;
        }
        .ai:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.12); background: #fff; }
        .ai::placeholder { color: #94a3b8; }

        /* ── Alerts ── */
        @keyframes fadeSlideIn { from { opacity:0; transform:translateY(-6px) } to { opacity:1; transform:translateY(0) } }
        .admin-alert { animation: fadeSlideIn .22s ease; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }

        /* ── Mobile ── */
        @media (max-width: 1023px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrap { padding-left: 0 !important; }
        }
        @media (min-width: 1024px) {
            .sidebar { transform: translateX(0) !important; }
            .sidebar-overlay { display: none !important; }
        }
    </style>
</head>
<body x-data="{ open: false }">

{{-- Overlay (mobile) --}}
<div class="sidebar-overlay fixed inset-0 z-30 bg-black/40"
     x-show="open"
     x-transition:enter="transition-opacity duration-200"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-200"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     @click="open=false" style="display:none"></div>

{{-- Sidebar --}}
<aside class="sidebar" :class="open ? 'open' : ''">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="sidebar-icon-wrap">
            <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
        </div>
        <div>
            <p style="color:#f1f5f9;font-weight:700;font-size:14px;line-height:1.2">Waskita</p>
            <p style="color:#f59e0b;font-size:9px;letter-spacing:.1em;text-transform:uppercase;font-weight:600;opacity:.8">Admin Panel</p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="sidebar-nav">
        @php
            $navItems = [
                ['r'=>'panel.dashboard',        'l'=>'Dashboard',  'icon'=>'home'],
                ['r'=>'panel.products.index',   'l'=>'Produk',     'icon'=>'box'],
                ['r'=>'panel.categories.index', 'l'=>'Kategori',   'icon'=>'tag'],
                ['r'=>'panel.messages.index',   'l'=>'Pesan',      'icon'=>'mail'],
                ['r'=>'panel.settings.index',   'l'=>'Pengaturan', 'icon'=>'settings'],
            ];
            $icons = [
                'home'     => 'M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z M9 22V12h6v10',
                'box'      => 'M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z M3.27 6.96L12 12.01l8.73-5.05M12 22.08V12',
                'tag'      => 'M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82zM7 7h.01',
                'mail'     => 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z M22 6l-10 7L2 6',
                'settings' => 'M12 15a3 3 0 100-6 3 3 0 000 6z M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z',
            ];
        @endphp

        @foreach($navItems as $item)
            @php $active = request()->routeIs($item['r'].'*'); @endphp
            <a href="{{ route($item['r']) }}" class="nav-link {{ $active ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="{{ $icons[$item['icon']] }}"/>
                </svg>
                {{ $item['l'] }}
                @if($item['r'] === 'panel.messages.index')
                    @php $unread = \App\Models\ContactMessage::where('is_read', false)->count() @endphp
                    @if($unread > 0)<span class="nav-badge">{{ $unread }}</span>@endif
                @endif
            </a>
        @endforeach
    </nav>

    {{-- Footer --}}
    <div class="sidebar-footer">
        <div class="user-row">
            <div class="user-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
            <div style="min-width:0">
                <p style="color:#e2e8f0;font-size:12.5px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p style="color:#64748b;font-size:10.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ Auth::user()->email ?? '' }}</p>
            </div>
        </div>
        <a href="{{ route('panel.password') }}" class="nav-link {{ request()->routeIs('panel.password') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
            Ganti Password
        </a>
        <form method="POST" action="{{ route('panel.logout') }}">
            @csrf
            <button type="submit" class="nav-link" style="width:100%">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- Main content --}}
<div class="main-wrap" style="padding-left:240px;min-height:100vh;display:flex;flex-direction:column;">

    {{-- Topbar --}}
    <header class="topbar">
        <button @click="open=!open"
                style="display:none;padding:8px;border-radius:8px;border:none;background:none;cursor:pointer;color:#64748b;"
                class="lg:hidden"
                onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div style="flex:1">
            <h1 style="font-size:15px;font-weight:700;color:#1e293b;margin:0">@yield('page-title','Dashboard')</h1>
        </div>

        <a href="{{ url('/') }}" target="_blank"
           style="display:inline-flex;align-items:center;gap:6px;font-size:12.5px;color:#64748b;text-decoration:none;padding:6px 12px;border-radius:8px;border:1.5px solid #e2e8f0;transition:all .15s;"
           onmouseover="this.style.borderColor='#f59e0b';this.style.color='#d97706';this.style.background='#fffbeb'"
           onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#64748b';this.style.background='transparent'">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Lihat Website
        </a>
    </header>

    {{-- Alerts --}}
    @if(session('success') || session('error'))
    <div style="padding: 16px 24px 0">
        @if(session('success'))
        <div class="admin-alert" style="display:flex;align-items:center;gap:10px;background:#f0fdf4;border:1.5px solid #bbf7d0;color:#15803d;font-size:13.5px;padding:12px 16px;border-radius:12px"
             x-data x-init="setTimeout(()=>{$el.style.transition='opacity .3s';$el.style.opacity='0';setTimeout(()=>$el.remove(),300)},3200)">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="admin-alert" style="display:flex;align-items:center;gap:10px;background:#fef2f2;border:1.5px solid #fecaca;color:#dc2626;font-size:13.5px;padding:12px 16px;border-radius:12px"
             x-data x-init="setTimeout(()=>{$el.style.transition='opacity .3s';$el.style.opacity='0';setTimeout(()=>$el.remove(),300)},4000)">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif
    </div>
    @endif

    {{-- Page --}}
    <main style="flex:1;padding:24px">
        @yield('content')
    </main>

    <footer style="text-align:center;font-size:11px;color:#94a3b8;padding:12px 24px">
        &copy; {{ date('Y') }} Waskita Admin Panel
    </footer>
</div>

<script>
    // Mobile sidebar responsive
    (function() {
        const sidebar = document.querySelector('.sidebar');
        const wrap    = document.querySelector('.main-wrap');
        const toggle  = document.querySelector('.lg\\:hidden');
        function check() {
            if (window.innerWidth < 1024) {
                wrap.style.paddingLeft = '0';
                if (toggle) toggle.style.display = 'inline-flex';
            } else {
                wrap.style.paddingLeft = '240px';
                if (toggle) toggle.style.display = 'none';
            }
        }
        check();
        window.addEventListener('resize', check);
    })();
</script>

</body>
</html>

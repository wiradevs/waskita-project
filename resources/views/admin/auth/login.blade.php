<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Waskita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: #f0ece4; font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        .login-card { background: #fff; border: 1px solid #e8e2d9; box-shadow: 0 8px 32px rgba(0,0,0,.06); }
        .admin-input { border: 1.5px solid #e2ddd7; border-radius: 10px; background: #fdfcfb; transition: border-color .15s, box-shadow .15s; padding: 11px 14px; font-size: 14px; color: #1c1917; width: 100%; }
        .admin-input:focus { border-color: #d97706; box-shadow: 0 0 0 3px rgba(217,119,6,.12); outline: none; }
        .admin-input::placeholder { color: #a8a29e; }
        .btn-login { background: #d97706; color: #fff; border-radius: 10px; padding: 11px; font-weight: 600; font-size: 14px; width: 100%; transition: background .15s, box-shadow .15s, transform .1s; }
        .btn-login:hover { background: #b45309; box-shadow: 0 4px 16px rgba(217,119,6,.25); transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 min-h-screen">

<div class="w-full max-w-sm" x-data="{ loading: false }">
    {{-- Logo --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-amber-600 shadow-lg shadow-amber-600/20 mb-5">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <h1 class="text-stone-800 text-2xl font-bold tracking-tight">Waskita Admin</h1>
        <p class="text-stone-500 text-sm mt-1.5">Masuk untuk mengelola website</p>
    </div>

    {{-- Card --}}
    <div class="login-card rounded-2xl p-8">
        @if($errors->any())
            <div class="flex items-center gap-2.5 bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-6">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('panel.login') }}" class="space-y-5"
              @submit="loading = true">
            @csrf

            <div>
                <label class="block text-stone-600 text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="admin-input"
                       placeholder="admin@waskita.com">
            </div>

            <div>
                <label class="block text-stone-600 text-sm font-medium mb-2">Password</label>
                <div class="relative" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" name="password" required
                           class="admin-input pr-10"
                           placeholder="••••••••">
                    <button type="button" @click="show = !show"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 transition-colors">
                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <input type="checkbox" name="remember" id="remember"
                       class="w-4 h-4 rounded text-amber-600 border-stone-300 focus:ring-amber-500">
                <label for="remember" class="text-stone-500 text-sm">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login flex items-center justify-center gap-2" :disabled="loading">
                <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <span x-text="loading ? 'Masuk...' : 'Masuk ke Admin'"></span>
            </button>
        </form>
    </div>

    <p class="text-center mt-6">
        <a href="{{ url('/') }}" class="text-stone-400 hover:text-stone-600 text-xs transition-colors inline-flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke website
        </a>
    </p>
</div>

</body>
</html>

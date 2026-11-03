<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopind — Belanja Mudah & Cepat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue:       #02066F;
            --blue-dark:  #020035;
            --blue-light: #EBEAED;
            --text:       #020035;
            --muted:      #2000B1;
            --border:     #EBEAED;
            --surface:    #F2F3F4;
            --bg:         #F2F3F4;
            --red:        #ED4B00;
        }
        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(135deg, #020035 0%, #02066F 100%);
            border-bottom: 1px solid #02066F;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 4px rgba(15,23,42,.15);
            overflow: hidden;
        }
        .navbar-inner {
            max-width: 1200px; margin: 0 auto;
            padding: 0 24px; height: 64px;
            display: flex; align-items: center; justify-content: space-between; gap: 24px;
        }
        .navbar-brand a {
            text-decoration: none; display: flex; align-items: center;
        }
        .navbar-links { display: flex; gap: 2px; }
        .navbar-links a {
            font-size: .875rem; font-weight: 600; color: rgba(255,255,255,0.75);
            text-decoration: none; padding: 7px 14px; border-radius: 8px; transition: all .15s;
        }
        .navbar-links a:hover, .navbar-links a.active { color: #ffffff; background: rgba(255,255,255,0.15); }
        .navbar-actions { display: flex; align-items: center; gap: 8px; }
        .icon-btn {
            width: 38px; height: 38px; border-radius: 10px;
            border: 1.5px solid rgba(255,255,255,0.25); background: rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.85); text-decoration: none; transition: all .15s; cursor: pointer;
        }
        .icon-btn:hover { border-color: #ffffff; color: #ffffff; background: rgba(255,255,255,0.2); }
        .navbar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 4px 12px 4px 4px; border-radius: 12px; border: 1.5px solid rgba(255,255,255,0.25);
        }
        .avatar {
            width: 28px; height: 28px; border-radius: 8px;
            background: rgba(255,255,255,0.2); color: white;
            font-size: .72rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .navbar-user span { font-size: .82rem; font-weight: 600; color: #ffffff; }
        .navbar-user span.admin-name { color: #ED4B00; }
        .btn-logout {
            background: none; border: none; font-family: inherit;
            font-size: .82rem; font-weight: 600; color: rgba(255,255,255,0.65);
            cursor: pointer; transition: color .15s; padding: 0;
        }
        .btn-logout:hover { color: #ffaaaa; }
        .btn-login {
            background: #ffffff; color: #020035; font-size: .875rem; font-weight: 700;
            padding: 8px 18px; border-radius: 10px; text-decoration: none; transition: background .15s;
        }
        .btn-login:hover { background: #EBEAED; }

        /* MAIN */
        .main { max-width: 1200px; margin: 0 auto; padding: 36px 24px 56px; }

        /* ALERTS */
        .alert {
            padding: 12px 16px; border-radius: 10px; font-size: .875rem;
            font-weight: 500; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
        }
        .alert-success { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
        .alert-error   { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="navbar-inner">
        <div class="navbar-brand">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Shopind" style="height:200px; width:auto;">
            </a>
        </div>
        <div class="navbar-links">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Produk</a>
            @auth
                @if(auth()->user()->isCustomer())
                    <a href="{{ route('order.riwayat') }}" class="{{ request()->routeIs('order.riwayat') ? 'active' : '' }}">Riwayat</a>
                @endif
            @endauth
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.index') }}" style="color:#ED4B00; font-weight:700;">Dashboard Admin</a>
            @endif
        </div>
        <div class="navbar-actions">
            <a href="{{ route('cart.index') }}" class="icon-btn" title="Keranjang">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
            </a>
            @auth
                <div class="navbar-user">
                    @if(auth()->user()->isCustomer())
                    <div style="font-size: .85rem; font-weight: 700; color: #ffffff; margin-right: 8px; display:flex; align-items:center; gap:8px;">
                        <span>💰 Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</span>
                        <a href="{{ route('topup.index') }}" style="background:#ED4B00; color:#ffffff; padding:4px 8px; border-radius:6px; border:1px solid #c43d00; text-decoration:none; font-size:.75rem; transition:all .15s;" title="Isi Saldo">+ Top Up</a>
                        <a href="{{ route('transfer.index') }}" style="background:#ED4B00; color:#ffffff; padding:4px 8px; border-radius:6px; border:1px solid #c43d00; text-decoration:none; font-size:.75rem; transition:all .15s;" title="Kirim Saldo">⇄ Transfer</a>
                    </div>
                    @endif
                    <div class="avatar">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
                    <span class="{{ auth()->user()->isAdmin() ? 'admin-name' : '' }}">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0; padding-left: 8px; border-left: 1px solid rgba(255,255,255,0.25);">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-login">Login</a>
            @endauth
        </div>
    </div>
</nav>

<main class="main">
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @yield('content')
</main>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopind - Belanja Mudah & Cepat</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Sora', sans-serif; background: #F2F3F4; color: #020035; }

        nav {
            background: linear-gradient(135deg, #020035 0%, #02066F 100%);
            border-bottom: 1px solid #02066F;
            position: sticky; top: 0; z-index: 50;
        }
        .nav-inner {
            max-width: 1200px; margin: 0 auto;
            padding: 0 24px; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-logo { text-decoration: none; display: flex; align-items: center; }
        .nav-links { display: flex; align-items: center; gap: 8px; }
        .nav-links a {
            padding: 8px 18px; border-radius: 8px; font-size: 14px;
            font-weight: 500; text-decoration: none; color: #ffffff; transition: background 0.15s;
        }
        .nav-links a:hover { background: rgba(255,255,255,0.15); }
        .nav-links .btn-primary { background: #ffffff; color: #020035; padding: 8px 20px; }
        .nav-links .btn-primary:hover { background: #EBEAED; }
        .nav-center { display: flex; gap: 24px; }
        .nav-center a { text-decoration: none; color: #ffffff; font-size: 14px; font-weight: 500; }
        .nav-center a:hover { color: #EBEAED; }

        .hero { background: linear-gradient(135deg, #EBEAED 0%, #F2F3F4 60%, #EBEAED 100%); padding: 80px 24px; }
        .hero-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; gap: 60px; }
        .hero-text { flex: 1; }
        .hero-badge {
            display: inline-block; background: #EBEAED; color: #020035;
            font-size: 13px; font-weight: 600; padding: 4px 14px;
            border-radius: 999px; margin-bottom: 20px; letter-spacing: 0.02em;
        }
        .hero-title { font-size: 52px; font-weight: 700; line-height: 1.15; color: #020035; margin-bottom: 18px; }
        .hero-title span { color: #02066F; }
        .hero-subtitle { font-size: 17px; color: #2000B1; line-height: 1.7; margin-bottom: 36px; max-width: 440px; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-hero-primary {
            background: #020035; color: #fff; padding: 14px 32px; border-radius: 10px;
            font-size: 15px; font-weight: 600; text-decoration: none;
            transition: background 0.15s, transform 0.1s; display: inline-block;
        }
        .btn-hero-primary:hover { background: #02066F; transform: translateY(-1px); }
        .btn-hero-secondary {
            background: #F2F3F4; color: #020035; padding: 14px 32px; border-radius: 10px;
            font-size: 15px; font-weight: 600; text-decoration: none;
            border: 1.5px solid #EBEAED; transition: border-color 0.15s, transform 0.1s; display: inline-block;
        }
        .btn-hero-secondary:hover { border-color: #2000B1; transform: translateY(-1px); }

        .hero-visual { flex: 1; display: flex; justify-content: center; align-items: center; }
        .hero-card-stack { position: relative; width: 340px; height: 300px; }
        .hero-card {
            position: absolute; background: #F2F3F4; border-radius: 16px; padding: 20px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08); border: 1px solid #EBEAED;
        }
        .hero-card.card-back { width: 260px; height: 160px; top: 20px; left: 60px; background: #EBEAED; transform: rotate(-4deg); }
        .hero-card.card-front { width: 280px; height: 180px; top: 60px; left: 30px; z-index: 2; }
        .card-tag { display: inline-block; background: #EBEAED; color: #020035; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 6px; margin-bottom: 10px; }
        .card-product-name { font-weight: 600; font-size: 15px; color: #020035; margin-bottom: 4px; }
        .card-price { color: #02066F; font-weight: 700; font-size: 18px; margin-bottom: 14px; }
        .card-bar { height: 6px; border-radius: 999px; background: #EBEAED; margin-bottom: 6px; }
        .card-bar-fill { height: 6px; border-radius: 999px; background: #020035; width: 70%; }
        .card-small-text { font-size: 11px; color: #2000B1; }
        .hero-stat {
            position: absolute; bottom: 0; right: 0; background: #F2F3F4;
            border-radius: 12px; padding: 12px 18px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); font-size: 13px; z-index: 3;
        }
        .hero-stat strong { display: block; font-size: 20px; color: #02066F; font-weight: 700; }

        .stats-bar { background: #020035; padding: 28px 24px; }
        .stats-inner { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap; gap: 16px; }
        .stat-item { text-align: center; color: #fff; }
        .stat-number { font-size: 28px; font-weight: 700; }
        .stat-label { font-size: 13px; opacity: 0.85; margin-top: 2px; }

        .section { padding: 64px 24px; }
        .section-inner { max-width: 1200px; margin: 0 auto; }
        .section-header { margin-bottom: 36px; }
        .section-header h2 { font-size: 30px; font-weight: 700; color: #020035; margin-bottom: 8px; }
        .section-header p { font-size: 15px; color: #2000B1; }

        .kategori-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .kategori-card {
            background: #F2F3F4; border-radius: 16px; padding: 28px 20px; text-align: center;
            border: 1.5px solid #EBEAED; text-decoration: none; color: inherit;
            transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s; cursor: pointer;
        }
        .kategori-card:hover { border-color: #02066F; box-shadow: 0 8px 24px rgba(2,6,111,0.1); transform: translateY(-2px); }
        .kategori-icon { width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 28px; }
        .kategori-name { font-weight: 600; font-size: 15px; color: #020035; margin-bottom: 4px; }
        .kategori-count { font-size: 13px; color: #2000B1; }

        .section-alt { background: #F2F3F4; }
        .produk-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .produk-card {
            background: white; border-radius: 16px; overflow: hidden;
            border: 1.5px solid #EBEAED; transition: box-shadow 0.2s, transform 0.15s;
            text-decoration: none; color: inherit; display: block;
        }
        .produk-card:hover { box-shadow: 0 8px 28px rgba(2,6,111,0.1); transform: translateY(-3px); }
        .produk-img { width: 100%; height: 180px; display: flex; align-items: center; justify-content: center; font-size: 48px; background: #EBEAED; }
        .produk-info { padding: 16px; }
        .produk-name { font-weight: 600; font-size: 14px; color: #020035; margin-bottom: 6px; line-height: 1.4; }
        .produk-price { color: #02066F; font-weight: 700; font-size: 16px; margin-bottom: 12px; }
        .produk-btn {
            display: block; width: 100%; background: #020035; color: #fff; border: none;
            border-radius: 8px; padding: 10px; font-size: 13px; font-weight: 600;
            cursor: pointer; text-align: center; text-decoration: none; transition: background 0.15s;
        }
        .produk-btn:hover { background: #02066F; }

        .cta-section { padding: 64px 24px; background: linear-gradient(135deg, #020035 0%, #02066F 100%); }
        .cta-inner { max-width: 700px; margin: 0 auto; text-align: center; color: #fff; }
        .cta-inner h2 { font-size: 36px; font-weight: 700; margin-bottom: 14px; }
        .cta-inner p { font-size: 16px; opacity: 0.85; margin-bottom: 32px; line-height: 1.6; }
        .btn-cta {
            display: inline-block; background: #F2F3F4; color: #020035;
            padding: 14px 36px; border-radius: 10px; font-size: 15px; font-weight: 700;
            text-decoration: none; transition: transform 0.15s;
        }
        .btn-cta:hover { transform: translateY(-2px); }

        footer { background: #020035; color: #2000B1; padding: 32px 24px; text-align: center; font-size: 14px; }
        footer strong { color: #fff; }

        @media (max-width: 900px) {
            .hero-inner { flex-direction: column; gap: 40px; padding: 0; }
            .hero-visual { display: none; }
            .hero-title { font-size: 36px; }
            .kategori-grid { grid-template-columns: repeat(2, 1fr); }
            .produk-grid { grid-template-columns: repeat(2, 1fr); }
            .stats-inner { gap: 24px; }
        }
        @media (max-width: 600px) {
            .hero-title { font-size: 28px; }
            .kategori-grid { grid-template-columns: repeat(2, 1fr); }
            .produk-grid { grid-template-columns: 1fr 1fr; }
            .nav-center { display: none; }
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav>
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <img src="/images/logo.png" alt="Shopind" style="height:200px; width:auto;">
            </a>
            <div class="nav-center">
                <a href="/">Home</a>
                <a href="/produk">Produk</a>
            </div>
            <div class="nav-links">
                @auth
                    <a href="/produk" class="btn-primary">Belanja</a>
                @else
                    <a href="{{ route('login') }}">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-text">
                <span class="hero-badge">✨ Toko Online Terpercaya</span>
                <h1 class="hero-title">Belanja <span>Mudah</span>,<br>Harga Terbaik</h1>
                <p class="hero-subtitle">Temukan ribuan produk pilihan dengan harga terjangkau. Pengiriman cepat, transaksi aman, dan layanan 24/7 untuk kenyamanan belanja kamu.</p>
                <div class="hero-actions">
                    <a href="/produk" class="btn-hero-primary">Mulai Belanja →</a>
                    <a href="{{ route('register') }}" class="btn-hero-secondary">Daftar Gratis</a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-card-stack">
                    <div class="hero-card card-back"></div>
                    <div class="hero-card card-front">
                        <span class="card-tag">🔥 Terlaris</span>
                        <div class="card-product-name">Laptop Modern Pro</div>
                        <div class="card-price">Rp 12.500.000</div>
                        <div class="card-bar"><div class="card-bar-fill"></div></div>
                        <div class="card-small-text">70% terjual • Stok terbatas</div>
                    </div>
                    <div class="hero-stat">
                        <strong>6.000+</strong>
                        <span>Produk tersedia</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATS BAR --}}
    <div class="stats-bar">
        <div class="stats-inner">
            <div class="stat-item"><div class="stat-number">10.000+</div><div class="stat-label">Pelanggan Aktif</div></div>
            <div class="stat-item"><div class="stat-number">6.000+</div><div class="stat-label">Produk Tersedia</div></div>
            <div class="stat-item"><div class="stat-number">99%</div><div class="stat-label">Kepuasan Pelanggan</div></div>
            <div class="stat-item"><div class="stat-number">24/7</div><div class="stat-label">Layanan Pelanggan</div></div>
        </div>
    </div>

    {{-- KATEGORI PRODUK --}}
    <section class="section">
        <div class="section-inner">
            <div class="section-header">
                <h2>Kategori Produk</h2>
                <p>Temukan produk sesuai kebutuhanmu</p>
            </div>
            <div class="kategori-grid">
                <a href="/produk?kategori=Laptop" class="kategori-card">
                    <div class="kategori-icon" style="background:#EBEAED;">💻</div>
                    <div class="kategori-name">Laptop</div>
                    <div class="kategori-count">120+ produk</div>
                </a>
                <a href="/produk?kategori=Audio" class="kategori-card">
                    <div class="kategori-icon" style="background:#EBEAED;">🎧</div>
                    <div class="kategori-name">Audio</div>
                    <div class="kategori-count">85+ produk</div>
                </a>
                <a href="/produk?kategori=Smartphone" class="kategori-card">
                    <div class="kategori-icon" style="background:#EBEAED;">📱</div>
                    <div class="kategori-name">Smartphone</div>
                    <div class="kategori-count">60+ produk</div>
                </a>
                <a href="/produk?kategori=Aksesoris" class="kategori-card">
                    <div class="kategori-icon" style="background:#EBEAED;">⌨️</div>
                    <div class="kategori-name">Aksesoris</div>
                    <div class="kategori-count">200+ produk</div>
                </a>
            </div>
        </div>
    </section>

    {{-- PRODUK UNGGULAN --}}
    <section class="section section-alt">
        <div class="section-inner">
            <div class="section-header">
                <h2>Produk Unggulan</h2>
                <p>Pilihan terbaik dengan harga terjangkau</p>
            </div>
            <div class="produk-grid">
                @forelse ($featured as $produk)
                <a href="{{ route('products.show', $produk->id) }}" class="produk-card">
                    <div class="produk-img" style="padding:0; overflow:hidden;">
                        @if ($produk->image)
                            <img src="{{ asset('storage/' . $produk->image) }}"
                                 alt="{{ $produk->name }}"
                                 style="width:100%; height:180px; object-fit:cover;">
                        @else
                            <span style="font-size:48px;">📦</span>
                        @endif
                    </div>
                    <div class="produk-info">
                        <div class="produk-name">{{ $produk->name }}</div>
                        <div class="produk-price">Rp {{ number_format($produk->price, 0, ',', '.') }}</div>
                        <div class="produk-btn">Lihat Detail</div>
                    </div>
                </a>
                @empty
                    <p style="color:#666; grid-column: span 4; text-align:center;">
                        Belum ada produk dengan gambar.
                    </p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- CTA BANNER --}}
    <section class="cta-section">
        <div class="cta-inner">
            <h2>Siap Mulai Belanja?</h2>
            <p>Daftar sekarang dan nikmati pengalaman belanja online yang mudah, cepat, dan aman bersama Shopind.</p>
            @auth
                <a href="/produk" class="btn-cta">Lihat Semua Produk →</a>
            @else
                <a href="{{ route('register') }}" class="btn-cta">Daftar Sekarang — Gratis!</a>
            @endauth
        </div>
    </section>

    {{-- FOOTER --}}
    <footer>
        <p>© {{ date('Y') }} <strong>Shopind</strong> — Belanja Mudah & Cepat. All rights reserved.</p>
    </footer>

</body>
</html>
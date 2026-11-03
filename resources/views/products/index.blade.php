@extends('layouts.app')

@section('content')
<style>
    .page-header { text-align: center; margin-bottom: 36px; }
    .page-header h1 { font-size: 1.875rem; font-weight: 800; color: var(--text); letter-spacing: -.5px; }
    .page-header p  { font-size: .95rem; color: var(--muted); margin-top: 6px; }

    .kategori-filter {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 28px;
    }
    .kategori-filter a {
        padding: 8px 20px;
        border-radius: 999px;
        font-size: .85rem;
        font-weight: 600;
        text-decoration: none;
        border: 1.5px solid var(--border);
        color: var(--muted);
        background: var(--surface);
        transition: all .15s;
    }
    .kategori-filter a:hover {
        border-color: var(--blue);
        color: var(--blue);
    }
    .kategori-filter a.active {
        background: var(--blue);
        color: white;
        border-color: var(--blue);
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .product-card {
        background: var(--surface);
        border-radius: 16px;
        border: 1.5px solid var(--border);
        overflow: hidden;
        transition: transform .2s, box-shadow .2s, border-color .2s;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(2,6,111,.12);
        border-color: var(--blue);
    }

    .product-img {
        width: 100%; height: 196px; object-fit: cover; display: block;
    }
    .product-img-placeholder {
        width: 100%; height: 196px;
        background: #F2F3F4;
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; gap: 8px;
        color: #EBEAED;
    }
    .product-img-placeholder svg { opacity: .5; }
    .product-img-placeholder span { font-size: .75rem; font-weight: 500; }

    .product-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
    .product-kategori-tag {
        display: inline-block;
        background: #EBEAED;
        color: #02066F;
        font-size: .7rem;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 999px;
        margin-bottom: 6px;
        text-transform: capitalize;
    }
    .product-name {
        font-size: .9rem; font-weight: 700; color: var(--text);
        line-height: 1.35; margin-bottom: 6px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .product-price { font-size: 1rem; font-weight: 800; color: var(--blue); margin-bottom: 14px; }

    .btn-detail {
        display: block; text-align: center;
        background: var(--blue); color: white;
        font-size: .82rem; font-weight: 700;
        padding: 10px 0; border-radius: 10px;
        text-decoration: none; transition: background .15s;
        margin-top: auto;
    }
    .product-card:hover .btn-detail { background: var(--blue-dark); }

    .empty-state {
        text-align: center; padding: 80px 24px;
        color: var(--muted);
    }
    .empty-state svg { margin: 0 auto 16px; opacity: .3; }
    .empty-state h2 { font-size: 1.1rem; font-weight: 700; color: var(--text); }
    .empty-state p  { font-size: .875rem; margin-top: 4px; }

    .search-area {
        display: flex;
        gap: 10px;
        max-width: 560px;
        align-items: center;
        margin-bottom: 20px;
    }
    .search-input {
        flex: 1;
        border: 2px solid #02066F;
        border-radius: 12px;
        background: #ffffff;
        font-size: 0.9rem;
        font-family: inherit;
        color: var(--text);
        padding: 10px 16px;
        outline: none;
        transition: box-shadow .15s;
        box-shadow: 0 4px 16px rgba(2,6,111,0.10);
    }
    .search-input::placeholder { color: #aaa; }
    .search-input:focus { box-shadow: 0 0 0 3px rgba(2,6,111,0.15); }
    .search-btn {
        background: var(--blue);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        font-family: inherit;
        transition: background .15s;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(2,6,111,0.2);
    }
    .search-btn:hover { background: var(--blue-dark); }
    .reset-btn {
        background: var(--border);
        color: var(--text);
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        white-space: nowrap;
        transition: background .15s;
    }
    .reset-btn:hover { background: #d0cfd4; }
</style>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div class="page-header" style="margin-bottom: 0; text-align: left;">
        <h1>Daftar Produk</h1>
        <p>Temukan produk terbaik di Shopind</p>
    </div>
    @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('admin.create') }}" style="background:#ED4B00; color:white; padding:10px 24px; border-radius:10px; text-decoration:none; font-weight:700; font-size:0.95rem; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 12px rgba(237,75,0,0.3);">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Produk (Admin)
        </a>
    @endif
</div>

{{-- SEARCH BAR --}}
<form method="GET" action="{{ route('products.index') }}">
    @if($kategoriAktif)
        <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
    @endif
    <div class="search-area">
        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="Cari produk..."
            class="search-input"
        >
        <button type="submit" class="search-btn">Cari</button>
        @if(!empty($search))
            <a href="{{ route('products.index', $kategoriAktif ? ['kategori' => $kategoriAktif] : []) }}" class="reset-btn">✕ Reset</a>
        @endif
    </div>
</form>

{{-- FILTER KATEGORI --}}
@php
    $kategoriList = ['Laptop', 'Audio', 'Smartphone', 'Wearable', 'Kamera', 'Aksesoris'];
@endphp
<div class="kategori-filter">
    <a href="{{ route('products.index', $search ? ['search' => $search] : []) }}"
       class="{{ !$kategoriAktif ? 'active' : '' }}">Semua</a>
    @foreach($kategoriList as $kat)
        <a href="{{ route('products.index', array_filter(['kategori' => $kat, 'search' => $search])) }}"
           class="{{ $kategoriAktif === $kat ? 'active' : '' }}">
            {{ $kat }}
        </a>
    @endforeach
</div>

@if($products->isEmpty())
    <div class="empty-state">
        <svg width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
        <h2>Produk tidak ditemukan</h2>
        <p>{{ !empty($search) ? 'Coba kata kunci lain atau pilih kategori lain.' : 'Coba pilih kategori lain.' }}</p>
    </div>
@else
    <div class="product-grid">
        @foreach($products as $product)
        <a href="{{ route('products.show', $product->id) }}" class="product-card">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" class="product-img" alt="{{ $product->name }}">
            @else
                <div class="product-img-placeholder">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                    <span>Tidak ada gambar</span>
                </div>
            @endif
            <div class="product-body">
                @if($product->kategori)
                    <span class="product-kategori-tag">{{ $product->kategori }}</span>
                @endif
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="btn-detail">Lihat Detail</div>
            </div>
        </a>
        @endforeach
    </div>
@endif
@endsection
@extends('layouts.app')

@section('content')
<style>
    .back-link {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: .875rem; font-weight: 600; color: var(--muted);
        text-decoration: none; margin-bottom: 24px;
        transition: color .15s;
    }
    .back-link:hover { color: var(--blue); }

    .product-detail-card {
        background: white;
        border-radius: 20px;
        border: 1.5px solid var(--border);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr 1fr;
        box-shadow: 0 8px 32px rgba(2,0,53,0.10);
    }

    .product-detail-img img {
        width: 100%; height: 100%;
        object-fit: cover; display: block;
        min-height: 420px;
    }
    .product-detail-img-placeholder {
        width: 100%; min-height: 420px;
        background: #F1F5F9;
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; gap: 10px; color: #CBD5E1;
    }
    .product-detail-img-placeholder span { font-size: .85rem; font-weight: 500; }

    .product-detail-info {
        padding: 40px;
        display: flex;
        flex-direction: column;
        background: linear-gradient(160deg, #020035 0%, #02066F 100%);
    }

    .product-detail-name {
        font-size: 1.6rem; font-weight: 800; color: #ffffff;
        letter-spacing: -.4px; line-height: 1.25;
    }
    .product-detail-price {
        font-size: 1.5rem; font-weight: 800; color: #ED4B00;
        margin-top: 14px;
    }
    .product-detail-stock {
        display: inline-flex; align-items: center; gap: 6px;
        margin-top: 14px; padding: 6px 14px; border-radius: 999px;
        background: rgba(255,255,255,0.1); color: #ffffff;
        font-size: .8rem; font-weight: 600;
        border: 1px solid rgba(255,255,255,0.2);
        width: fit-content;
    }
    .product-detail-stock svg { flex-shrink: 0; }

    .product-detail-divider {
        height: 1px; background: rgba(255,255,255,0.15); margin: 24px 0;
    }
    .product-detail-desc-label {
        font-size: .8rem; font-weight: 700; color: rgba(255,255,255,0.6);
        text-transform: uppercase; letter-spacing: .06em; margin-bottom: 8px;
    }
    .product-detail-desc {
        font-size: .925rem; color: rgba(255,255,255,0.8); line-height: 1.65;
        flex: 1;
    }

    .btn-cart {
        display: block; width: 100%; text-align: center;
        background: #ED4B00; color: white;
        font-family: inherit; font-size: .95rem; font-weight: 700;
        padding: 14px 0; border-radius: 12px; border: none;
        cursor: pointer; transition: all .15s;
        margin-top: 28px;
        box-shadow: 0 4px 16px rgba(237,75,0,0.35);
    }
    .btn-cart:hover { background: #c43d00; transform: translateY(-1px); }
    .btn-cart:active { transform: scale(.98); }
</style>

<a href="/produk" class="back-link">    
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
    Kembali ke Produk
</a>

<div class="product-detail-card">
    <div class="product-detail-img">
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
        @else
            <div class="product-detail-img-placeholder">
                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                </svg>
                <span>Tidak ada gambar</span>
            </div>
        @endif
    </div>

    <div class="product-detail-info">
        <h1 class="product-detail-name">{{ $product->name }}</h1>
        <div class="product-detail-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

        <div class="product-detail-stock">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M20 6 9 17l-5-5"/>
            </svg>
            Stok: {{ $product->stock }} unit
        </div>

        <div class="product-detail-divider"></div>

        <div class="product-detail-desc-label">Deskripsi Produk</div>
        <p class="product-detail-desc">{{ $product->description }}</p>

        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-cart">
                + Tambah ke Keranjang
            </button>
        </form>
    </div>
</div>
@endsection
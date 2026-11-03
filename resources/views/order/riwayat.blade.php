@extends('layouts.app')

@section('content')
<style>
    .page-title { font-size: 1.5rem; font-weight: 800; color: #020035; margin-bottom: 6px; }
    .page-sub { font-size: .875rem; color: #2000B1; margin-bottom: 28px; }

    .order-card {
        background: white;
        border: 1.5px solid #EBEAED;
        border-radius: 16px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(2,0,53,0.07);
        transition: box-shadow .2s;
    }
    .order-card:hover { box-shadow: 0 8px 28px rgba(2,0,53,0.12); }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background: linear-gradient(135deg, #020035 0%, #02066F 100%);
        border-bottom: none;
    }
    .order-id { font-size: .875rem; color: #ffffff; font-weight: 700; }
    .order-date { font-size: .78rem; color: rgba(255,255,255,0.65); margin-top: 2px; }
    .order-status {
        display: inline-block;
        background: #16a34a;
        color: white;
        font-size: .75rem;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 999px;
        box-shadow: 0 2px 8px rgba(22,163,74,0.3);
    }

    .order-items { padding: 8px 20px; }
    .order-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #F2F3F4;
    }
    .order-item:last-child { border-bottom: none; }
    .order-item-img {
        width: 56px; height: 56px;
        border-radius: 10px;
        object-fit: cover;
        background: #EBEAED;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; flex-shrink: 0;
        border: 1.5px solid #EBEAED;
        overflow: hidden;
    }
    .order-item-img img { width: 56px; height: 56px; border-radius: 10px; object-fit: cover; }
    .order-item-info { flex: 1; }
    .order-item-name { font-size: .875rem; font-weight: 700; color: #020035; margin-bottom: 4px; }
    .order-item-qty { font-size: .78rem; color: #2000B1; }
    .order-item-price { font-size: .95rem; font-weight: 800; color: #02066F; }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 20px;
        border-top: 1.5px solid #EBEAED;
        background: #F8F8FA;
    }
    .order-total-label { font-size: .85rem; color: #2000B1; font-weight: 600; }
    .order-total-price { font-size: 1.1rem; font-weight: 800; color: #ED4B00; }

    .empty-state {
        text-align: center; padding: 80px 24px; color: #2000B1;
    }
    .empty-state h2 { font-size: 1.1rem; font-weight: 700; color: #020035; margin-bottom: 8px; }
    .empty-state p { font-size: .875rem; margin-bottom: 20px; }
    .btn-belanja {
        display: inline-block; background: #020035; color: white;
        padding: 12px 28px; border-radius: 10px; font-weight: 700;
        text-decoration: none; font-size: .875rem; transition: background .15s;
    }
    .btn-belanja:hover { background: #02066F; }
</style>

<div class="page-title">Riwayat Pemesanan</div>
<div class="page-sub">Semua transaksi pembelian kamu di Shopind</div>

@if($orders->isEmpty())
    <div class="empty-state">
        <svg width="56" height="56" fill="none" stroke="#EBEAED" stroke-width="1.5" viewBox="0 0 24 24" style="margin: 0 auto 16px;">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
        <h2>Belum ada pesanan</h2>
        <p>Yuk mulai belanja dan temukan produk favoritmu!</p>
        <a href="{{ route('products.index') }}" class="btn-belanja">Mulai Belanja</a>
    </div>
@else
    @foreach($orders as $order)
    <div class="order-card">
        <div class="order-header">
            <div>
                <div class="order-id">Order #{{ $order->id }}</div>
                <div class="order-date">{{ $order->created_at->format('d M Y') }}</div>
            </div>
            <span class="order-status">{{ ucfirst($order->status) }}</span>
        </div>

        <div class="order-items">
            @foreach($order->items as $item)
            <div class="order-item">
                <div class="order-item-img">
                    @if($item->product && $item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                    @else
                        🛍️
                    @endif
                </div>
                <div class="order-item-info">
                    <div class="order-item-name">{{ $item->product->name ?? 'Produk tidak tersedia' }}</div>
                    <div class="order-item-qty">{{ $item->quantity }} item × Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                </div>
                <div class="order-item-price">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
            </div>
            @endforeach
        </div>

        <div class="order-footer">
            <span class="order-total-label">Total Pembayaran</span>
            <span class="order-total-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
    </div>
    @endforeach
@endif
@endsection
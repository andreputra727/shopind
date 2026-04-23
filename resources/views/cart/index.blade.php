@extends('layouts.app')

@section('content')
    <style>
        .cart-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.4px;
            margin-bottom: 28px;
        }

        /* EMPTY STATE */
        .cart-empty {
            text-align: center;
            padding: 90px 24px;
            background: var(--surface);
            border-radius: 20px;
            border: 1.5px solid var(--border);
        }

        .cart-empty-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: var(--blue-light);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .cart-empty h2 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text);
        }

        .cart-empty p {
            font-size: .875rem;
            color: var(--muted);
            margin-top: 6px;
        }

        .btn-shop {
            display: inline-block;
            margin-top: 20px;
            background: var(--blue);
            color: white;
            font-size: .875rem;
            font-weight: 700;
            padding: 11px 24px;
            border-radius: 10px;
            text-decoration: none;
            transition: background .15s;
        }

        .btn-shop:hover {
            background: var(--blue-dark);
        }

        /* CART LAYOUT */
        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
            align-items: start;
        }

        /* CART ITEMS */
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .cart-item {
            background: var(--surface);
            border-radius: 14px;
            border: 1.5px solid var(--border);
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: border-color .15s;
        }

        .cart-item:hover {
            border-color: #BFDBFE;
        }

        .cart-item-img {
            width: 72px;
            height: 72px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .cart-item-img-placeholder {
            font-size: .65rem;
            color: #94A3B8;
            font-weight: 500;
            text-align: center;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-size: .9rem;
            font-weight: 700;
            color: var(--text);
        }

        .cart-item-price {
            font-size: .875rem;
            font-weight: 800;
            color: var(--blue);
            margin-top: 4px;
        }

        .cart-item-qty {
            font-size: .8rem;
            font-weight: 600;
            color: var(--muted);
            background: #F1F5F9;
            padding: 4px 10px;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .btn-remove {
            background: none;
            border: none;
            cursor: pointer;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #CBD5E1;
            transition: all .15s;
            flex-shrink: 0;
        }

        .btn-remove:hover {
            background: #FEF2F2;
            color: var(--red);
        }

        /* SUMMARY */
        .cart-summary {
            background: var(--surface);
            border-radius: 16px;
            border: 1.5px solid var(--border);
            padding: 24px;
            position: sticky;
            top: 84px;
        }

        .cart-summary h3 {
            font-size: .95rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 18px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: .875rem;
            color: var(--muted);
            margin-bottom: 10px;
        }

        .summary-row span:last-child {
            font-weight: 600;
            color: var(--text);
        }

        .summary-divider {
            height: 1px;
            background: var(--border);
            margin: 14px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: .975rem;
            font-weight: 700;
            color: var(--text);
        }

        .summary-total span:last-child {
            color: var(--blue);
            font-size: 1.1rem;
        }

        .btn-checkout {
            display: block;
            width: 100%;
            text-align: center;
            background: var(--blue);
            color: white;
            font-size: .9rem;
            font-weight: 700;
            padding: 13px 0;
            border-radius: 11px;
            text-decoration: none;
            transition: background .15s;
            margin-top: 20px;
        }

        .btn-checkout:hover {
            background: var(--blue-dark);
        }
    </style>

    <h1 class="cart-title">Keranjang Belanja</h1>

    @if($items->isEmpty())
        <div class="cart-empty">
            <div class="cart-empty-icon">
                <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <path d="M16 10a4 4 0 0 1-8 0" />
                </svg>
            </div>
            <h2>Keranjang Belanja Kosong</h2>
            <p>Yuk, mulai belanja sekarang!</p>
            <a href="{{ route('products.index') }}" class="btn-shop">Lihat Produk</a>
        </div>
    @else
        <div class="cart-layout">
            <div class="cart-items">
                @foreach($items as $item)
                    <div class="cart-item">
                        <div class="cart-item-img">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                            @else
                                <div class="cart-item-img-placeholder">No Image</div>
                            @endif
                        </div>
                        <div class="cart-item-info">
                            <div class="cart-item-name">{{ $item->product->name }}</div>
                            <div class="cart-item-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="cart-item-qty">Qty: {{ $item->quantity }}</div>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove" title="Hapus">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                    <path d="M10 11v6M14 11v6" />
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <h3>Ringkasan Belanja</h3>
                <div class="summary-row">
                    <span>Subtotal ({{ $items->count() }} item)</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                </div>
                <div class="summary-divider"></div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <!-- Bagian Pemilihan Metode Pembayaran -->
            <form action="{{ route('order.checkout') }}" method="GET" style="margin-top: 24px;">
                <span class="font-semibold text-gray-800"
                    style="font-size: .95rem; margin-bottom: 12px; display: block;">Metode Pembayaran</span>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="display: flex; items-center; gap: 10px; cursor: pointer; padding: 12px; border: 1px solid var(--border); border-radius: 10px; background: #fff;">
                        <input type="radio" name="payment" value="debit" checked style="accent-color: var(--blue); width: 16px; height: 16px; margin-top:2px;">
                        <span style="font-size: .875rem; color: var(--text); font-weight: 500;">💳 Kartu Debit</span>
                    </label>
                    <label style="display: flex; items-center; gap: 10px; cursor: pointer; padding: 12px; border: 1px solid var(--border); border-radius: 10px; background: #fff;">
                        <input type="radio" name="payment" value="qr" style="accent-color: var(--blue); width: 16px; height: 16px; margin-top:2px;">
                        <span style="font-size: .875rem; color: var(--text); font-weight: 500;">📱 Kode QR (Qris)</span>
                    </label>
                    <label style="display: flex; items-center; gap: 10px; cursor: pointer; padding: 12px; border: 1px solid var(--border); border-radius: 10px; background: #fff;">
                        <input type="radio" name="payment" value="saldo" style="accent-color: var(--blue); width: 16px; height: 16px; margin-top:2px;">
                        <span style="font-size: .875rem; color: var(--text); font-weight: 500;">💰 Saldo Akun (Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }})</span>
                    </label>
                </div>

                <button type="submit" class="btn-checkout w-full border-0">Checkout Sekarang →</button>
            </form>
        </div>
        </div>
    @endif
@endsection
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

        .cart-empty h2 { font-size: 1.15rem; font-weight: 700; color: var(--text); }
        .cart-empty p { font-size: .875rem; color: var(--muted); margin-top: 6px; }

        .btn-shop {
            display: inline-block; margin-top: 20px;
            background: var(--blue); color: white;
            font-size: .875rem; font-weight: 700;
            padding: 11px 24px; border-radius: 10px;
            text-decoration: none; transition: background .15s;
        }
        .btn-shop:hover { background: var(--blue-dark); }

        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 24px;
            align-items: start;
        }

        .cart-items { display: flex; flex-direction: column; gap: 12px; }

        .cart-item {
            background: white;
            border-radius: 14px;
            border: 1.5px solid var(--border);
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all .15s;
            box-shadow: 0 2px 8px rgba(2,0,53,0.05);
        }
        .cart-item:hover {
            border-color: var(--blue);
            box-shadow: 0 4px 16px rgba(2,0,53,0.10);
        }

        .cart-item-img {
            width: 72px; height: 72px;
            border-radius: 10px; overflow: hidden;
            flex-shrink: 0; background: #F1F5F9;
            display: flex; align-items: center; justify-content: center;
            border: 1.5px solid #EBEAED;
        }
        .cart-item-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .cart-item-img-placeholder { font-size: .65rem; color: #94A3B8; font-weight: 500; text-align: center; }

        .cart-item-info { flex: 1; }
        .cart-item-name { font-size: .9rem; font-weight: 700; color: var(--text); }
        .cart-item-price { font-size: .875rem; font-weight: 800; color: #ED4B00; margin-top: 4px; }

        .qty-control { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
        .qty-btn {
            width: 32px; height: 32px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: #fff;
            font-size: 1.1rem; font-weight: 700;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--blue);
            transition: all .15s; line-height: 1;
        }
        .qty-btn:hover { background: var(--blue); color: white; border-color: var(--blue); }
        .qty-num {
            min-width: 32px; text-align: center;
            font-weight: 700; font-size: .9rem; color: var(--text);
        }

        .btn-remove {
            background: none; border: none; cursor: pointer;
            width: 34px; height: 34px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #CBD5E1; transition: all .15s; flex-shrink: 0;
        }
        .btn-remove:hover { background: #FEF2F2; color: var(--red); }

        .cart-summary {
            background: white;
            border-radius: 16px;
            border: 1.5px solid var(--border);
            padding: 24px;
            position: sticky;
            top: 84px;
            box-shadow: 0 4px 20px rgba(2,0,53,0.08);
        }
        .cart-summary h3 {
            font-size: 1rem; font-weight: 800;
            color: var(--text); margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1.5px solid var(--border);
        }

        .summary-row {
            display: flex; justify-content: space-between; align-items: center;
            font-size: .875rem; color: var(--muted); margin-bottom: 10px;
        }
        .summary-row span:last-child { font-weight: 600; color: var(--text); }

        .summary-divider { height: 1.5px; background: var(--border); margin: 14px 0; }

        .summary-total {
            display: flex; justify-content: space-between; align-items: center;
            font-size: 1rem; font-weight: 800; color: var(--text);
        }
        .summary-total span:last-child { color: #ED4B00; font-size: 1.15rem; }

        .payment-label {
            font-size: .9rem; font-weight: 700;
            margin-bottom: 12px; display: block;
            color: var(--text);
        }
        .payment-option {
            display: flex; align-items: center; gap: 10px;
            cursor: pointer; padding: 12px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px; background: #F8F8FA;
            transition: all .15s;
        }
        .payment-option:hover { border-color: var(--blue); background: #EEF2FF; }
        .payment-option input[type="radio"] { accent-color: var(--blue); width: 16px; height: 16px; }
        .payment-option span { font-size: .875rem; color: var(--text); font-weight: 500; }

        .btn-checkout {
            display: block; width: 100%; text-align: center;
            background: linear-gradient(135deg, #020035 0%, #02066F 100%);
            color: white; font-size: .95rem; font-weight: 700;
            padding: 14px 0; border-radius: 11px;
            border: none; cursor: pointer;
            transition: all .15s; margin-top: 16px;
            box-shadow: 0 4px 12px rgba(2,0,53,0.2);
        }
        .btn-checkout:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(2,0,53,0.3); }
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

                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="qty-control">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="qty-btn">−</button>
                            <span class="qty-num">{{ $item->quantity }}</span>
                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="qty-btn">+</button>
                        </form>

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
                <div class="summary-divider"></div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('order.checkout') }}" method="GET" style="margin-top: 24px;">
                    <span class="payment-label">Metode Pembayaran</span>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label class="payment-option">
                            <input type="radio" name="payment" value="debit" checked>
                            <span>💳 Kartu Debit</span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment" value="qr">
                            <span>📱 Kode QR (Qris)</span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment" value="saldo">
                            <span>💰 Saldo Akun (Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }})</span>
                        </label>
                    </div>
                    <button type="submit" class="btn-checkout">Checkout Sekarang →</button>
                </form>
            </div>
        </div>
    @endif
@endsection
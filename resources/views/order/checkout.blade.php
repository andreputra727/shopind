@extends('layouts.app')

@section('content')
<div style="max-width:520px; margin:0 auto;">
    <h1 style="font-size:1.25rem; font-weight:700; color:#020035; margin-bottom:24px;">Checkout</h1>

    <div style="background:white; border-radius:16px; border:1.5px solid #EBEAED; padding:28px;">
        <h3 style="font-weight:600; color:#020035; margin-bottom:16px;">Ringkasan Pesanan</h3>

        @foreach($items as $item)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid #EBEAED;">
            <div>
                <p style="font-size:.9rem; font-weight:600; color:#020035;">{{ $item->product->name }}</p>
                <p style="font-size:.75rem; color:#2000B1;">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
            </div>
            <p style="font-size:.9rem; font-weight:600; color:#020035;">
                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
            </p>
        </div>
        @endforeach

        <div style="display:flex; justify-content:space-between; align-items:center; padding-top:16px; margin-top:8px;">
            <span style="font-weight:700; color:#020035;">Total Pembayaran</span>
            <span style="font-weight:800; color:#02066F; font-size:1.1rem;">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>

        @if($payment === 'saldo')
        <div style="display:flex; justify-content:space-between; align-items:center; padding-top:10px; margin-top:10px; border-top:1px solid #EBEAED;">
            <span style="font-size:.875rem; color:#2000B1; font-weight:500;">Saldo Anda</span>
            <span style="font-size:.875rem; font-weight:700; color:{{ Auth::user()->balance < $total ? '#ED4B00' : '#02066F' }};">
                Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}
            </span>
        </div>
        @if(Auth::user()->balance < $total)
        <div style="margin-top:12px; padding:12px; background:#fff0eb; border:1px solid #ED4B00; border-radius:8px; font-size:.8rem; color:#ED4B00; font-weight:500;">
            Peringatan: Saldo Anda tidak mencukupi. Silakan <a href="{{ route('topup.index') }}" style="font-weight:700; text-decoration:underline; color:#ED4B00;">Top Up Saldo</a>.
        </div>
        @endif
        @else
        <div style="display:flex; justify-content:space-between; align-items:center; padding-top:10px; margin-top:10px; border-top:1px solid #EBEAED;">
            <span style="font-size:.875rem; color:#2000B1; font-weight:500;">Metode Tagihan</span>
            <span style="font-size:.875rem; font-weight:600; color:#020035;">
                {{ $payment === 'qr' ? 'Kode QR (Qris)' : 'Kartu Debit' }}
            </span>
        </div>
        @endif

        <div style="display:flex; gap:12px; margin-top:24px;">
            <a href="{{ route('cart.index') }}"
               style="flex:1; text-align:center; border:1.5px solid #EBEAED; color:#020035; padding:11px; border-radius:10px; text-decoration:none; font-size:.875rem; font-weight:600; transition:all .15s;">
                Kembali ke Keranjang
            </a>
            <form action="{{ route('order.confirm') }}" method="POST" style="flex:1;">
                @csrf
                <input type="hidden" name="payment" value="{{ $payment }}">
                <button type="submit"
                    {{ ($payment === 'saldo' && Auth::user()->balance < $total) ? 'disabled' : '' }}
                    style="width:100%; border:none; padding:11px; border-radius:10px; font-size:.875rem; font-weight:700; color:white; cursor:{{ ($payment === 'saldo' && Auth::user()->balance < $total) ? 'not-allowed' : 'pointer' }}; background:{{ ($payment === 'saldo' && Auth::user()->balance < $total) ? '#EBEAED' : '#02066F' }}; font-family:inherit;">
                    Bayar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
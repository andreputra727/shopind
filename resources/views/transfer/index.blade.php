@extends('layouts.app')

@section('content')
<style>
    .transfer-wrapper {
        max-width: 480px; margin: 0 auto;
    }
    .transfer-title {
        font-size: 1.4rem; font-weight: 800; color: #020035;
        text-align: center; margin-bottom: 24px; letter-spacing: -.3px;
    }
    .transfer-card {
        background: white; border-radius: 20px;
        border: 1.5px solid #EBEAED; padding: 32px;
        box-shadow: 0 8px 32px rgba(2,0,53,0.10);
    }
    .form-group { margin-bottom: 20px; }
    .form-label {
        display: block; font-size: .85rem; font-weight: 700;
        color: #020035; margin-bottom: 8px;
    }
    .input-wrapper { position: relative; }
    .input-icon {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        color: #aaa; display: flex; align-items: center;
    }
    .form-input {
        width: 100%; padding: 12px 14px 12px 42px;
        border: 2px solid #EBEAED; border-radius: 10px;
        font-family: inherit; font-size: .9rem; color: #020035;
        background: #F8F8FA; outline: none; transition: all .15s;
        box-sizing: border-box;
    }
    .form-input:focus {
        border-color: #02066F;
        background: white;
        box-shadow: 0 0 0 3px rgba(2,6,111,0.10);
    }
    .form-input::placeholder { color: #bbb; }
    .input-prefix {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        font-weight: 700; color: #2000B1; font-size: .9rem;
    }
    .form-input-prefix { padding-left: 40px; }
    .form-error { font-size: .78rem; color: #ED4B00; margin-top: 5px; font-weight: 500; }

    .saldo-info {
        display: flex; justify-content: space-between; align-items: center;
        margin-top: 10px; padding: 10px 14px;
        background: #F0FDF4; border-radius: 8px;
        border: 1px solid #BBF7D0;
        font-size: .82rem; font-weight: 600;
    }
    .saldo-info span:first-child { color: #2000B1; }
    .saldo-info span:last-child { color: #16a34a; font-weight: 700; }
    .saldo-info span.saldo-empty { color: #ED4B00; }

    .divider { height: 1.5px; background: #EBEAED; margin: 24px 0; }

    .btn-transfer {
        width: 100%; padding: 14px;
        background: linear-gradient(135deg, #020035 0%, #02066F 100%);
        color: white; font-family: inherit;
        font-size: .95rem; font-weight: 700;
        border: none; border-radius: 11px;
        cursor: pointer; transition: all .15s;
        box-shadow: 0 4px 12px rgba(2,0,53,0.2);
    }
    .btn-transfer:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(2,0,53,0.3); }
    .btn-transfer:active { transform: scale(.98); }

    .transfer-note {
        text-align: center; font-size: .78rem;
        color: #aaa; margin-top: 14px; font-weight: 500;
    }
</style>

<div class="transfer-wrapper">
    <h1 class="transfer-title">Transfer Saldo Ke Teman</h1>

    <div class="transfer-card">
        <form action="{{ route('transfer.process') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Email Akun Tujuan</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="contoh: customer2@shopind.com"
                        class="form-input @error('email') border-red-500 @enderror">
                </div>
                @error('email')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nominal Transfer (Rp)</label>
                <div class="input-wrapper">
                    <span class="input-prefix">Rp</span>
                    <input type="number" name="amount" value="{{ old('amount') }}" required min="1"
                        placeholder="0"
                        class="form-input form-input-prefix @error('amount') border-red-500 @enderror">
                </div>
                @error('amount')<p class="form-error">{{ $message }}</p>@enderror

                <div class="saldo-info">
                    <span>Sisa Saldo Anda:</span>
                    <span class="{{ Auth::user()->balance <= 0 ? 'saldo-empty' : '' }}">
                        Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="divider"></div>

            <button type="submit" class="btn-transfer">⇄ Kirim Saldo Sekarang</button>
            <p class="transfer-note">* Transfer bebas biaya admin (Rp 0).</p>
        </form>
    </div>
</div>
@endsection
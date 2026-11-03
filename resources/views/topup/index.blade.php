@extends('layouts.app')

@section('content')
<style>
    .topup-wrapper { max-width: 480px; margin: 0 auto; }
    .topup-title {
        font-size: 1.4rem; font-weight: 800; color: #020035;
        text-align: center; margin-bottom: 24px; letter-spacing: -.3px;
    }
    .topup-card {
        background: white; border-radius: 20px;
        border: 1.5px solid #EBEAED; padding: 32px;
        box-shadow: 0 8px 32px rgba(2,0,53,0.10);
    }
    .form-label {
        display: block; font-size: .85rem; font-weight: 700;
        color: #020035; margin-bottom: 12px;
    }
    .nominal-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
        margin-bottom: 16px;
    }
    .nominal-option { position: relative; }
    .nominal-option input[type="radio"] { display: none; }
    .nominal-label {
        display: block; text-align: center;
        padding: 14px; border-radius: 12px;
        border: 2px solid #EBEAED; background: #F8F8FA;
        font-weight: 700; font-size: .95rem; color: #020035;
        cursor: pointer; transition: all .15s;
    }
    .nominal-label:hover {
        border-color: #02066F; background: #EEF2FF; color: #02066F;
    }
    .nominal-option input[type="radio"]:checked + .nominal-label {
        border-color: #02066F; background: #02066F; color: white;
        box-shadow: 0 4px 12px rgba(2,6,111,0.25);
    }

    .custom-amount-wrapper {
        margin-bottom: 24px;
    }
    .custom-amount-label {
        font-size: .8rem; font-weight: 600; color: ##020035;
        margin-bottom: 8px; display: block;
    }
    .custom-amount-input-wrap { position: relative; }
    .custom-prefix {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        font-weight: 700; color: #020035; font-size: .9rem;
    }
    .custom-input {
        width: 100%; padding: 12px 14px 12px 40px;
        border: 2px solid #EBEAED; border-radius: 12px;
        font-family: inherit; font-size: .95rem; font-weight: 600;
        color: #020035; background: #F8F8FA; outline: none;
        transition: all .15s; box-sizing: border-box;
    }
    .custom-input:focus {
        border-color: #02066F; background: white;
        box-shadow: 0 0 0 3px rgba(2,6,111,0.10);
    }
    .custom-input::placeholder { color: #bbb; font-weight: 400; }

    .divider { height: 1.5px; background: #EBEAED; margin: 20px 0; }

    .payment-option {
        display: flex; align-items: center; gap: 10px;
        cursor: pointer; padding: 12px 14px;
        border: 1.5px solid #EBEAED;
        border-radius: 10px; background: #F8F8FA;
        transition: all .15s; margin-bottom: 8px;
    }
    .payment-option:last-child { margin-bottom: 0; }
    .payment-option:hover { border-color: #02066F; background: #EEF2FF; }
    .payment-option input[type="radio"] { accent-color: #02066F; width: 16px; height: 16px; }
    .payment-option span { font-size: .875rem; color: #020035; font-weight: 500; }

    .btn-topup {
        width: 100%; padding: 14px;
        background: linear-gradient(135deg, #020035 0%, #02066F 100%);
        color: white; font-family: inherit;
        font-size: .95rem; font-weight: 700;
        border: none; border-radius: 11px;
        cursor: pointer; transition: all .15s;
        margin-top: 24px;
        box-shadow: 0 4px 12px rgba(2,0,53,0.2);
    }
    .btn-topup:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(2,0,53,0.3); }
    .btn-topup:active { transform: scale(.98); }
</style>

<div class="topup-wrapper">
    <h1 class="topup-title">Top Up Saldo Pribadi</h1>

    <div class="topup-card">
        <form action="{{ route('topup.process') }}" method="POST">
            @csrf

            <label class="form-label">Pilih Nominal Top Up</label>
            <div class="nominal-grid">
                <div class="nominal-option">
                    <input type="radio" name="amount" value="50000" id="amt1" onchange="clearCustom()">
                    <label for="amt1" class="nominal-label">Rp 50.000</label>
                </div>
                <div class="nominal-option">
                    <input type="radio" name="amount" value="100000" id="amt2" onchange="clearCustom()">
                    <label for="amt2" class="nominal-label">Rp 100.000</label>
                </div>
                <div class="nominal-option">
                    <input type="radio" name="amount" value="250000" id="amt3" onchange="clearCustom()">
                    <label for="amt3" class="nominal-label">Rp 250.000</label>
                </div>
                <div class="nominal-option">
                    <input type="radio" name="amount" value="500000" id="amt4" onchange="clearCustom()">
                    <label for="amt4" class="nominal-label">Rp 500.000</label>
                </div>
            </div>

            <div class="custom-amount-wrapper">
                <span class="custom-amount-label">Atau masukkan nominal sendiri:</span>
                <div class="custom-amount-input-wrap">
                    <span class="custom-prefix">Rp</span>
                    <input type="number" id="customAmount" placeholder="Contoh: 75000" min="1"
                        class="custom-input"
                        oninput="uncheckAll()">
                </div>
            </div>

            <div class="divider"></div>

            <label class="form-label">Metode Pembayaran</label>
            <div style="display:flex; flex-direction:column;">
                <label class="payment-option">
                    <input type="radio" name="method" value="debit" checked>
                    <span>💳 Kartu Debit</span>
                </label>
                <label class="payment-option">
                    <input type="radio" name="method" value="qr">
                    <span>📱 Kode QR (Qris)</span>
                </label>
            </div>

            <button type="submit" class="btn-topup" onclick="return setCustomAmount()">+ Konfirmasi Top Up</button>
        </form>
    </div>
</div>

<script>
    function clearCustom() {
        document.getElementById('customAmount').value = '';
    }

    function uncheckAll() {
        document.querySelectorAll('input[name="amount"]').forEach(r => r.checked = false);
    }

    function setCustomAmount() {
        const custom = document.getElementById('customAmount').value;
        const selected = document.querySelector('input[name="amount"]:checked');

        if (custom && custom > 0) {
            // buat input hidden dengan nilai custom
            const existing = document.getElementById('hiddenAmount');
            if (existing) existing.remove();
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'amount';
            hidden.id = 'hiddenAmount';
            hidden.value = custom;
            document.querySelector('form').appendChild(hidden);
            return true;
        }

        if (!selected) {
            alert('Pilih nominal top up terlebih dahulu!');
            return false;
        }
        return true;
    }
</script>
@endsection
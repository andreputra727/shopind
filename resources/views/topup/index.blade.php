@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto">
    <h1 class="text-xl font-semibold text-gray-800 mb-6 text-center">Top Up Saldo Pribadi</h1>

    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <form action="{{ route('topup.process') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Nominal Top Up</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="border border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                        <input type="radio" name="amount" value="50000" class="hidden peer" required>
                        <div class="font-bold text-gray-700 peer-checked:text-blue-600">Rp 50.000</div>
                    </label>
                    <label class="border border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                        <input type="radio" name="amount" value="100000" class="hidden peer">
                        <div class="font-bold text-gray-700 peer-checked:text-blue-600">Rp 100.000</div>
                    </label>
                    <label class="border border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                        <input type="radio" name="amount" value="250000" class="hidden peer">
                        <div class="font-bold text-gray-700 peer-checked:text-blue-600">Rp 250.000</div>
                    </label>
                    <label class="border border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                        <input type="radio" name="amount" value="500000" class="hidden peer">
                        <div class="font-bold text-gray-700 peer-checked:text-blue-600">Rp 500.000</div>
                    </label>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                <div class="flex flex-col gap-2">
                    <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="method" value="debit" checked class="w-4 h-4 text-blue-600">
                        <span class="font-medium text-gray-800 text-sm">💳 Kartu Debit</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="method" value="qr" class="w-4 h-4 text-blue-600">
                        <span class="font-medium text-gray-800 text-sm">📱 Kode QR (Qris)</span>
                    </label>
                </div>
            </div>

            <button type="submit" style="width: 100%; border: none; padding: 12px; border-radius: 8px; font-size: 1rem; font-weight: bold; color: #ffffff; cursor: pointer; background-color: #2563EB; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#1D4ED8'" onmouseout="this.style.backgroundColor='#2563EB'">
                Konfirmasi Top Up
            </button>
        </form>
    </div>
</div>

<style>
    .peer:checked + div { color: var(--blue); }
    label:has(.peer:checked) { border-color: var(--blue); background: var(--blue-light); }
</style>
@endsection

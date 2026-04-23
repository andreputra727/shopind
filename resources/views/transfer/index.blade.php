@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto">
    <h1 class="text-xl font-semibold text-gray-800 mb-6 text-center">Transfer Saldo Ke Teman</h1>

    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <form action="{{ route('transfer.process') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Akun Tujuan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh: customer2@shopind.com" class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nominal Transfer (Rp)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 font-bold text-gray-500">Rp</span>
                    <input type="number" name="amount" value="{{ old('amount') }}" required min="1" placeholder="0" class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 @error('amount') border-red-500 @enderror">
                </div>
                @error('amount')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                
                <p class="text-xs text-gray-500 mt-2 font-medium flex justify-between">
                    <span>Sisa Saldo Anda:</span>
                    <span class="{{ Auth::user()->balance <= 0 ? 'text-red-500' : 'text-green-600' }}">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</span>
                </p>
            </div>

            <button type="submit" style="width: 100%; border: none; padding: 12px; border-radius: 8px; font-size: 1rem; font-weight: bold; color: #ffffff; cursor: pointer; background-color: #2563EB; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#1D4ED8'" onmouseout="this.style.backgroundColor='#2563EB'">
                Kirim Saldo Sekarang
            </button>
            <p class="text-center text-xs text-gray-400 mt-4">* Transfer bebas biaya admin (Rp 0).</p>
        </form>
    </div>
</div>
@endsection

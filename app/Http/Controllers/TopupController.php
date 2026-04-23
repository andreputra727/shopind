<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    public function index()
    {
        return view('topup.index');
    }

    public function process(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'method' => 'required|in:debit,qr'
        ]);

        $user = Auth::user();
        $user->balance += $request->amount;
        $user->save();

        return redirect()->route('products.index')->with('success', 'Top Up Saldo sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' berhasil!');
    }
}

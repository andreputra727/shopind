<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index()
    {
        return view('transfer.index');
    }

    public function process(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'amount' => 'required|numeric|min:1',
        ], [
            'email.exists' => 'Akun dengan email tersebut tidak ditemukan di sistem.',
            'amount.min' => 'Nominal transfer tidak valid.',
        ]);

        $sender = Auth::user();
        $receiverEmail = $request->input('email');
        $amount = $request->input('amount');

        if ($sender->email === $receiverEmail) {
            return back()->with('error', 'Gagal: Anda tidak dapat mentransfer saldo ke akun Anda sendiri.');
        }

        if ($sender->balance < $amount) {
            return back()->with('error', 'Gagal: Saldo Anda tidak mencukupi untuk melakukan transfer ini.');
        }

        try {
            DB::transaction(function () use ($sender, $receiverEmail, $amount) {
                // Lock rows for update
                $senderUser = User::where('id', $sender->id)->lockForUpdate()->first();
                $receiverUser = User::where('email', $receiverEmail)->lockForUpdate()->first();

                // Double check balance inside transaction
                if ($senderUser->balance < $amount) {
                    throw new \Exception('Saldo tidak mencukupi.');
                }

                // Mutasi
                $senderUser->balance -= $amount;
                $receiverUser->balance += $amount;

                $senderUser->save();
                $receiverUser->save();
            });

            return redirect()->route('products.index')->with('success', 'Transfer saldo sebesar Rp ' . number_format($amount, 0, ',', '.') . ' ke ' . $receiverEmail . ' berhasil diajukan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem saat memproses transfer: ' . $e->getMessage());
        }
    }
}

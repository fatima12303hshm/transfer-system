<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function is_numeric;

class TransactionController extends Controller
{
    public function fetchUserTransactions(Request $request)
    {
        $userId = $request->header('user_id');
        if (!$userId || !is_numeric($userId)) {
            return response()->json(['error' => 'unauthenticated'], 401);
        }

        $transactions = Transaction::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->get()
            ->map(function ($transaction) use ($userId) {
                $transaction->name = $transaction->sender_id == $userId
                    ? $transaction->receiver->name
                    : $transaction->sender->name;

                unset($transaction->receiver, $transaction->sender);

                return $transaction;
            });

        $sentTransactions = $transactions->where('sender_id', $userId)->values();
        $receivedTransactions = $transactions->where('receiver_id', $userId)->values();

        return response()->json([
            'status' => 'success',
            'data' => [
                'sent' => $sentTransactions,
                'received' => $receivedTransactions,
            ],
        ]);
    }



    public function submitTransaction(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:users,qr_code',
            'amount' => 'numeric|min:1'
        ]);

        $userId = $request->header('user_id');
        if (!$userId || !is_numeric($userId)) {
            return response()->json(['error' => 'user id is required'], 400);
        }
        $sender = User::find($userId);
        if (!$sender) {
            return response()->json(['error' => 'unauthenticated'], 401);
        }

        $receiver = User::where('qr_code', $request->code)->first();
        if (!$receiver) {
            return response()->json(['error' => 'receiver not found'], 404);
        }

        if ($sender->id == $receiver->id) {
            return response()->json(['error' => 'Cannot transfer to the same user'], 422);
        }

        if ($sender->balance < $request->amount) {
            return response()->json(['error' => 'Insufficient balance'], 422);
        }

        DB::transaction(function () use ($sender, $receiver, $request) {
            $sender->balance -= $request->amount ?? 1;
            $receiver->balance += $request->amount ?? 1;

            $sender->save();
            $receiver->save();
            Transaction::create(
                [
                    'amount' => $request->amount ?? 1,
                    'sender_id' => $sender->id,
                    'receiver_id' => $receiver->id,
                    'created_at' => now()
                ]
            );
        });
        return response()->json(['status' => 'success', 'message' => 'points transferred successfully'], 201);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loginUser(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            return response()->json(['status' => 'success', 'message' => 'User Authenticated Successfully', 'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'balance' => $user->balance,
                'qr_code' => $user->qr_code
            ]], 200);
        }
        return response()->json(['error' => 'User Not Found'], 404);
    }

    public function setQrCode(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:users,qr_code'
        ]);

        $user = User::find($request->header('user_id'));
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->qr_code = $request->code;
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'QR code updated successfully'], 200);
    }

    public function getUserData(Request $request)
    {
        $user = User::find($request->header('user_id'));
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json(['status' => 'success', 'message' => 'User data fetched', 'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'balance' => $user->balance,
            'qr_code' => $user->qr_code
        ]], 200);
    }

    // public function fetchUserDataFromQR(Request $request)
    // {
    //     $request->validate([
    //         'code' => 'required|exists:users,qr_code'
    //     ]);
    //     $user = User::where('qr_code', $request->code)->first();
    //     if (!$user) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }
    //     return response()->json(['status' => 'success', 'message' => 'User data fetched', 'data' => [
    //         'name' => $user->name,
    //         'balance' => $user->balance,
    //         'qr_code' => $user->qr_code
    //     ]], 200);
    // }
}

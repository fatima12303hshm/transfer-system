<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:users,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422);
        }
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
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:users,qr_code'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422);
        }

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
}

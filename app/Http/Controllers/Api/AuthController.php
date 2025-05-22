<?php

namespace App\Http\Controllers\API;

use App\Actions\User\RegisterUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    public function register(Request $request, RegisterUser $registerUser)
    {
        $user = $registerUser->handle($request->all());

        $token = $user->createToken('MyAppToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully.',
            'token' => $token,
            'user' => UserResource::make($user),
            'profile' => SellerResource::make($user->profile)
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $user->image = asset('images/users') . '/' . $user->image;
        $token = $user->createToken('MyAppToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'token' => $token,
            'user' => UserResource::make($user),
            'profile' => SellerResource::make($user->profile)
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user(),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth('sanctum')->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $result = $user->save();
        return $this->success($result, 'Password reset successful.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminAuthController extends Controller
{


    public function isAdminExists()
    {
       return User::where('role', 'admin')->exists();
    }

    public function register(Request $request)
    {
        if ($this->isAdminExists()) {
            return response()->json([
                'message' => 'Registration is not allowed . Admin already registered ! '
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'regex:/^[a-zA-Z0-9_.\s]+$/', 'min:3', 'max:50'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->max(50)->letters()->numbers()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid inputs',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $user = User::create([
            'username' => $validated['username'] ,
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);
        
        $token = $user->createToken('admin-token')->plainTextToken;
        return response()->json([
            'message' => 'admin registered successfully ',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role
            ],
            'token' => $token
        ]);
    }


    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid inputs',
                'errors' => $validator->errors()
            ], 422);
        }
        $credentials = $validator->validated();
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'invalid credentials'], 401);
        }

        $user = Auth::user();
        if ($user->role !== 'admin') {
            Auth::logout(); // revoke session for non-admin
            return response()->json(['message' => 'access denied . User is not an admin'], 403);
        }

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'logged in successfully',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
            ],
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        // delete all tokens for admin (all devices)

        // if ($request->user()->role !== 'admin') {
        //     return response()->json([
        //         'message' => 'access denied . only admin can logged out from this endpoint'
        //     ],403);
        // }

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'logged out successfully',
        ]);
    }
}

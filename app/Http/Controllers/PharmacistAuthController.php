<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PharmacistAuthController extends Controller
{
    public function login(Request $request)
    {

        // if(Auth::check()){
        //      return response()->json([
        //     'message' => 'You are already logged in.',
        // ], 200);
        // }

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid inputs',
                'errors' => $validator->errors()
            ], 422);
        }
        $credentials = $validator->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'invalid credentials'
            ], 401);
        }

        $pharmacist = Auth::user();

        if($pharmacist->disabled){
            Auth::logout() ;
            return response()->json([
                'message' => 'your account is disabled and cannot log in ' ,
            ],403);
        }


        // if ($pharmacist->role !== 'pharmacist') {
        //     Auth::logout();
        //     return response()->json([
        //         'message' => 'access denied . only pharmacist allowed',
        //     ], 403);
        // }

        $token = $pharmacist->createToken('pharmacist-token')->plainTextToken;

        return response()->json([
            'message' => 'logged in successfully',
            'pharmacist' => [
                'id' => $pharmacist->id,
                'username' => $pharmacist->username
            ],
            'token' => $token,
        ]);
    }

    public function logout(Request $request){

        $request->user()->tokens()->delete();
        return response()->json(['message' => 'logged out successfully'],200);
    }


    

}

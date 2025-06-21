<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

// pharmacists management
class AdminPharmacistController extends Controller
{
    public function createPharmacist(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9_.\s]+$/',
                'min:3',
                'max:255',
                Rule::unique('users', 'username') ,
                // Rule::unique('users', 'username')->where('disabled', 'false')
            ],
            'password' => ['required', 'confirmed',  Password::min(8)->max(50)->letters()->numbers()],
            'salary' => ['required', 'numeric', 'min:0', 'max:10000']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid inputs',
                'errors' => $validator->errors()
            ], 422);
        }
        $validated = $validator->validated();

        $pharmacist = User::create([
            'username' => $validated['username'],
            'password' =>  Hash::make($validated['password']),
            'salary' => $validated['salary'],
            'role' => 'pharmacist',

        ]);


        return response()->json([
            'message' => 'pharmacist created successfully',
            'pharmacist' => [
                'id' => $pharmacist->id,
                'username' => $pharmacist->username,
                'salary' => $pharmacist->salary,
                'role' => $pharmacist->role,
                'created_at' => $pharmacist->created_at->format('Y-m-d h:i'),
            ],
        ], 201);
    }

    public function getAllPharmacists()
    {

        $pharmacists = User::where('role', 'pharmacist')->where('disabled', 'false')->get();
        if ($pharmacists->isempty()) {
            return response()->json([
                'message' => 'no pharmacists found',
            ], 404);
        }

        return response()->json([
            'message' => 'pharmacists retrieved successfully',
            'pharmacists' => $pharmacists
        ], 200);
    }

    public function showPharmacist($id)
    {
        $pharmacist = User::with(['purchaseInvoices', 'saleInvoices'])->where('role', 'pharmacist')->where('disabled', false)->find($id);

        if (!$pharmacist) {
            return response()->json([
                'message' => ['Pharmacist not found!']
            ], 404);
        }
        return response()->json([
            'message' => 'pharmacist retrieved successfully',
            'pharmacist' => $pharmacist,
        ]);
    }

    public function editPharmacist(Request $request, $id)
    {
        $pharmacist = User::where('role', 'pharmacist')->where('disabled', false)->find($id);

        if (!$pharmacist) {
            return response()->json([
                'message' => ['Pharmacist not found!']
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => ['sometimes', 'string', 'regex:/^[a-zA-Z0-9_.\s]+$/', 'min:3', 'max:255', Rule::unique('users', 'username')->ignore($id)],
            'password' => ['sometimes', 'confirmed', Password::min(8)->letters()->numbers()],
            'salary' => ['sometimes', 'numeric', 'min:0', 'max:10000'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid inputs',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $newData = [];

        if (isset($validated['username']) && $validated['username'] !== $pharmacist->username) {
            $newData['username'] = $validated['username'];
        }
        if (isset($validated['password']) && !Hash::check($validated['password'], $pharmacist->password)) {
            $newData['password'] = Hash::make($validated['password']);
        }
        if (isset($validated['salary']) && $validated['salary'] !== $pharmacist->salary) {
            $newData['salary'] = $validated['salary'];
        }

        if (empty($newData)) {
            return response()->json([
                'message' => 'No changes were made!',
            ], 200);
        }

        $pharmacist->update($newData);

        return response()->json([
            'message' => 'Pharmacist updated successfully',
            'pharmacist' => $pharmacist
        ], 200);
    }

    public function deletePharmacist($id)
    {

        $pharmacist = User::where('role', 'pharmacist')->where('disabled', false)->find($id);

        if (!$pharmacist) {
            return response()->json([
                'message' => ['Pharmacist not found!']
            ], 404);
        }

        $pharmacist->disabled = true;
        $pharmacist->save();

        return response()->json([
            'message' => "the pharmacist {$pharmacist->username} has been deleted successfully "
        ], 200);
    }
}

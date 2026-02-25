<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Dev;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'username' => ['required', 'unique:users,username', 'min:4', 'max:60'],
            'password' => ['required', 'min:5', 'max:20'],
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'forbidden',
                'message' => $validated->user(),
            ], 400);
        }

        $data_user = $validated->validate();
        $data_user['password'] = Hash::make($data_user['password']);

        $user = User::create($data_user);

        // buat token aces
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
        ], 201);

    }

    public function signIn(Request $request)
    {
        // user
        $validated = Validator::make($request->all(), [
            'username' => ['required', 'min:4', 'max:60'],
            'password' => ['required', 'min:5', 'max:20'],
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'forbidden',
                'message' => $validated->user(),
            ]);
        }

        logger('validasi lewat', $validated->validate());

        $data = $validated->validate();

        logger('cek request yang masuk', $request->all());

        // cek user terlebih dahulu
        $user = User::where('username', $data['username'])->first();

        if ($user !== null) {

            if (! Hash::check($data['password'], $user->password)) {
                return response()->json([
                    'status' => 'invalid',
                    'message' => 'wrong username or password',
                ], 401);
            }

            $token = $user->createToken('api_token')->plainTextToken;
            Log::info('user login berhasil', ['username' => $user->username]);

            return response()->json([
                'status' => 'success',
                'token' => $token,
            ], 200);
        }

        // admin
        $admin = Admin::where('username', $data['username'])->first();

        if ($admin !== null) {
            if (! Hash::check($data['password'], $admin->password)) {
                return response()->json([
                    'status' => 'invalid',
                    'message' => 'wrong username or password',
                ], 401);
            }

            $token = $admin->createToken('api_token')->plainTextToken;
            Log::info('admin login berhasil', ['username' => $admin->username]);

            return response()->json([
                'status' => 'success',
                'token' => $token,
            ], 200);
        }

        // dev
        $dev = Dev::where('username', $data['username'])->first();

        if ($dev !== null) {
            if (! Hash::check($data['password'], $dev->password)) {
                return response()->json([
                    'status' => 'invalid',
                    'message' => 'wrong username or password',
                ], 401);
            }

            $token = $dev->createToken('api_token')->plainTextToken;
            Log::info('dev login berhasil', ['username' => $dev->username]);

            return response()->json([
                'status' => 'success',
                'token' => $token,
            ], 200);
        }

        
        return response()->json([
            'status' => 'invalid',
            'message' => 'wrong username or password',
        ], 401);

    }

     public function signOut(Request $request){

        try {
            $user = $request->user();

            
            if($user === null){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User tidak ditemukan atau token invalid'
                ], 401);
            }

           
            $user->currentAccessToken()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil logout',
                'username' => $user->username
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error saat logout: ' . $e->getMessage()
            ], 500);
        }
    }
}

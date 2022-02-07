<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller {
    
    public function __construct() {
        $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
    }

    // User Register
    public function register(Request $request) {
    	
        $validator = Validator::make($request->all(), [
            'user_id'  => 'required|string|max:255|unique:users',
            'user_nm'  => 'required|string|max:255',
            'password' => 'required|string',
        ]);
            
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()->toArray()
            ], 400);
        }
                
        $user = User::create([
            'user_id'  => $request->user_id,
            'user_nm'  => $request->user_nm,
            'password' => DB::select("SELECT HEX(AES_ENCRYPT('".$request->password."', '".env('DB_ENCRYPT', '8ugust_password_hex')."')) AS password")[0]->password,
        ]);
            
        return response()->json([
            'message' => 'User created.',
            'user' => $user
        ]);	
    }

    // User Login
    public function login() {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    // User Auth
    public function me() {
        return response()->json(auth()->user());
    }

    // User Logout
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    // User Refresh
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    // Token
    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
	
	
}
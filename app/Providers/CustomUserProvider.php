<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomUserProvider extends EloquentUserProvider
{
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];
        $password = DB::select("SELECT HEX(AES_ENCRYPT('".$plain."', '".env('DB_ENCRYPT', '8ugust_password_hex')."')) AS password")[0]->password;
        return $password === $user->getAuthPassword();
    }
}
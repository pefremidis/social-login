<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handle()
    {
        $user = Socialite::driver('google')->user();

        $user = User::firstOrCreate([
            'email' => $user->getEmail()
        ], [
            'name' => $user->getName(),
            'password' => Hash::make(Str::random())
        ]);

        Auth::login($user, true);

        return redirect(route('home'));
    }
}

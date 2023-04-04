<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

use App\Models\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //Redirects user to google login

    public function googleOathRedirect()
    {
        return [
            'redirect_to' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl()
        ];
    }

    // Handles the callback from google
    public function googleOathCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        // Check if user is registered or do an update
        $user = User::updateOrCreate([
            'google_id' => $user->id,
            'email' => $user->email,
        ],
        [
            "name" => $user->name,
            "profile_img" => $user->avatar,
        ]
        );

        $token = $user->createToken('api_spa');

        // redirect to frontend with token
        return redirect(env("FRONTEND_URL") . '?token=' . $token->plainTextToken);
    }
}

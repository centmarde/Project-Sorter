<?php

namespace App\Http\Controllers;

use Google\Client as GoogleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GoogleLoginController extends Controller
{
    protected $googleClient;

    public function __construct()
    {
        $this->googleClient = new GoogleClient();
        $this->googleClient->setClientId(env('GOOGLE_CLIENT_ID'));
        $this->googleClient->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $this->googleClient->setRedirectUri(env('GOOGLE_REDIRECT_URL'));
        $this->googleClient->addScope(['email', 'profile']);
    }

    /**
     * Redirect to Google OAuth consent screen.
     */
    public function redirectToGoogle()
    {
        $authUrl = $this->googleClient->createAuthUrl();
        return redirect($authUrl);
    }

    /**
     * Handle the callback from Google OAuth.
     */
    public function handleGoogleCallback(Request $request)
    {
        if ($request->has('code')) {
            $this->googleClient->fetchAccessTokenWithAuthCode($request->get('code'));
            $token = $this->googleClient->getAccessToken();

            // Retrieve user info
            $oauth2 = new \Google\Service\Oauth2($this->googleClient);
            $googleUser = $oauth2->userinfo->get();

            // Store user data in session or database
            Session::put('user', [
                'id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'avatar' => $googleUser->picture,
            ]);

            return redirect('/');
        }

        return redirect('/login')->with('error', 'Authentication failed');
    }
}

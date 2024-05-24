<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FAQRCode\Google2FA;

class AuthController extends Controller
{
    //Add new user
    public function register(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=>Hash::make($request->password),
        ]);
        return response()->json(['message' => 'User registered successfully']);
    }

    // Add Login method
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email','password']);

        if(!Auth::attempt($credentials)){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $request->user();

        if($user){
            $google2fa = new Google2FA();
            $user->secret2fa = $google2fa->generateSecretKey();
            $user->save();
        }

        return response()->json([
            'message' => 'Login successful, enter your 2FA code',
            'code_url' => $this->getQRCodeUrl($user->email, $user->secret2fa),
        ]);
    }

    // Generated QRCode Url
    protected function getQRCodeUrl($email, $secret)
    {
        $google2fa = new Google2FA();
        return $google2fa -> getQRCodeUrl(
            'GassApp', $email, $secret
        );
    }

}

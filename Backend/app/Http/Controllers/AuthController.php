<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FAQRCode\QRCode\Chillerlan;

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
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    // Add Login method
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if($user){
            $tempToken = bin2hex(random_bytes(32));
            cache([$tempToken => $user->id], now()->addMinutes(10));
            return response()->json(['two_factor_required' => true, 'temp_token' => $tempToken]);
        }

        // Generate Token for user
        $token = $user->createToken('authToken')->plainTexToken;

        return response()->json(['token' => $token]);
    }

    // Generated QRCode
    public function getQRCode(Request $request)
    {
        $userId = cache($request->temp_token);
        if (!$userId) {
            return response()->json(['message' => 'Invalid temp Token'], 400);
        }
        $user = User::find($userId);
        $google2fa = new Google2FA();
        $secretKey = $google2fa->generateSecretKey();
        $user->secret2fa = $secretKey;
        $user->save();

        $google2fa->setQrCodeService(new Chillerlan());
        $qrCodeUrl = $google2fa -> getQRCodeInline(
            'GassApp', $user->email, $secretKey
        );

        return response()->json(['qr_code_url'=> $qrCodeUrl]);
    }

    //Verify 2FA Token
    public function verify2faToken(Request $request)
    {
        $userId = cache($request->temp_token);
        if (!$userId) {
            return response()->json(['message' => 'Invalid temp Token'], 400);
        }

        $user = User::find($userId);
        $google2fa = new Google2FA();

        $isValid = $google2fa->verifyKey($user->secret2fa, $request->token);
        dd($isValid);
        if( $isValid ) {
            $token = $user->createToken('authToken')->plainTexToken;
            return response()->json(['token' => $token, 'success' => true]);
        }

        return response()->json(['message' => 'Invalid code 2FA'], 400);
    }

}

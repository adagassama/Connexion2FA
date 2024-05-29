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
        $validatedUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = User::create([
                'name' => $validatedUser['name'],
                'email' => $validatedUser['email'],
                'password' => Hash::make($validatedUser['password'], ),
            ]);
            return response()->json(['message' => 'Utilisateur enregistré avec succès'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Echec lors de la création du compte Utilisateur'], 500);
        }
    }

    // Add Login method
    public function login(Request $request)
    {
        $validatedLogin = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validatedLogin['email'])->first();

        if (!$user || !Hash::check($validatedLogin['password'], $user->password)) {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        $tempToken = bin2hex(random_bytes(32));
        cache([$tempToken => $user->id], now()->addMinutes(10));
        // Generate Token for user
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['two_factor_required' => true, 'temp_token' => $tempToken, 'token' => $token]);

    }

    // Generated QRCode
    public function getQRCode(Request $request)
    {
        $userId = cache($request->temp_token);
        if (!$userId) {
            return response()->json(['message' => 'Temp Token invalide'], 400);
        }

        $user = User::find($userId);
        $google2fa = new Google2FA();
        $secretKey = $google2fa->generateSecretKey();
        $user->secret2fa = $secretKey;
        $user->save();

        $google2fa->setQrCodeService(new Chillerlan());
        $qrCodeUrl = $google2fa->getQRCodeInline('GassApp', $user->email, $secretKey);

        return response()->json(['qr_code_url' => $qrCodeUrl]);
    }

    //Verify 2FA Token
    public function verify2faToken(Request $request)
    {
        $userId = cache($request->temp_token);
        if (!$userId) {
            return response()->json(['message' => 'Temp Token Invalide'], 400);
        }

        $user = User::find($userId);
        $google2fa = new Google2FA();

        $isValid = $google2fa->verifyKey($user->secret2fa, $request->token);

        if ($isValid) {
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token, 'success' => true]);
        }

        return response()->json(['message' => 'Code 2FA invalide']);
    }

}

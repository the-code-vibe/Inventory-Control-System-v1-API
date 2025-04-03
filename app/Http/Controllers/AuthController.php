<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }
    
        $token = JWTAuth::fromUser($user);
    
        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso',
            'data' => [
                'token' => $token,
                'user' => [
                    'uuid' => $user->uuid,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'phone' => $user->phone,
                    'status' => $user->status,
                    'is_admin' => $user->role === 'admin'
                ]
            ]
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();
        $token = Str::random(6);

        $user->code_verification_account = $token;
        $user->save();

        Mail::to($user->email)->send(new ResetPasswordMail($token));

        return response()->json([
            'success' => true,
            'message' => 'Um e-mail foi enviado com as instruções para redefinir a senha.'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('reset_password_token', $request->token)
            ->where('reset_password_expires_at', '>', now())
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Token inválido ou expirado.'], 400);
        }

        $user->password_hash = Hash::make($request->password);
        $user->reset_password_token = null;
        $user->reset_password_expires_at = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Senha redefinida com sucesso.'
        ]);
    }
}

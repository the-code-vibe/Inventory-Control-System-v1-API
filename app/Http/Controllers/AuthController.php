<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;

/**
 * @OA\Info(
 *      title="API de Autenticação",
 *      version="1.0.0",
 *      description="Documentação da API de autenticação usando Swagger no Lumen"
 * )
 *
 * @OA\Tag(
 *     name="Autenticação",
 *     description="Endpoints relacionados à autenticação do usuário"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Realiza o login do usuário",
     *     tags={"Autenticação"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="usuario@email.com"),
     *             @OA\Property(property="password", type="string", format="password", example="senha123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login realizado com sucesso"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1..."),
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="uuid", type="string", example="123e4567-e89b-12d3-a456-426614174000"),
     *                     @OA\Property(property="name", type="string", example="João Silva"),
     *                     @OA\Property(property="email", type="string", example="usuario@email.com"),
     *                     @OA\Property(property="avatar", type="string", example="https://exemplo.com/avatar.jpg"),
     *                     @OA\Property(property="phone", type="string", example="+55 11 99999-9999"),
     *                     @OA\Property(property="status", type="string", example="ativo"),
     *                     @OA\Property(property="is_admin", type="boolean", example=false)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Credenciais inválidas")
     *         )
     *     )
     * )
     */
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
}

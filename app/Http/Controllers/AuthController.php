<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Cadastro de usuário
    public function register(Request $request)
    {
        // Validações
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Validação de e-mail
            'password' => 'required|string|min:6|confirmed', // Confirmação de senha
        ]);

        // Criação do usuário
        $user = $this->userService->createUser($request->all());

        return response()->json(['message' => 'Usuário criado com sucesso', 'user' => $user], 201);
    }

    // Login de usuário
    public function login(Request $request)
    {
        // Validações
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        return response()->json([
            'token' => $token,
            'user' => Auth::user(),
        ]);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}

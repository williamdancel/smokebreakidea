<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $result = $this->authService->register($request->all());

        if ($result['success']) {
            return response()->json($result);
        }

        return response()->json($result, $result['code']);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $result = $this->authService->login(
            $credentials, 
            $request->boolean('remember')
        );

        if ($result['success']) {
            return response()->json($result);
        }

        return response()->json($result, $result['code']);
    }
    
    public function getCurrentUser(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                    'is_registered' => $user->is_registered,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch user data'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $result = $this->authService->logout();

        if ($result['success']) {
            return response()->json($result);
        }

        return response()->json($result, $result['code']);
    }
}
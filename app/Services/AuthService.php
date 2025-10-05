<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    protected $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function register(array $data): array
    {
        try {
            $user = $this->userModel->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'is_registered' => true,
            ]);

            Auth::login($user);

            return $this->successResponse([
                'user' => $user,
                'redirect' => '/dashboard'
            ], 'Registration successful!');

        } catch (\Exception $e) {
            return $this->errorResponse('Registration failed: ' . $e->getMessage());
        }
    }

    public function login(array $credentials, bool $remember = false): array
    {
        try {
            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();
                request()->session()->regenerate();

                return $this->successResponse([
                    'user' => $user,
                    'redirect' => '/dashboard'
                ], 'Login successful!');
            }

            return $this->errorResponse('The provided credentials do not match our records.', 401);

        } catch (\Exception $e) {
            return $this->errorResponse('Login failed: ' . $e->getMessage());
        }
    }

    public function logout(): array
    {
        try {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return $this->successResponse(null, 'Logged out successfully!');

        } catch (\Exception $e) {
            return $this->errorResponse('Logout failed: ' . $e->getMessage());
        }
    }
}
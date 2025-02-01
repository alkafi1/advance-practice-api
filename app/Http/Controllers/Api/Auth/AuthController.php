<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->validated());
            return $this->successResponse(new UserResource($user), 'User registered successfully', 201);
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());
        if ($result) {
            return $this->successResponse($result, 'Login successful');
        }
        return $this->errorResponse('Invalid credentials', 401);
    }

    public function logout()
    {
        $this->authService->logout(auth()->user());
        return $this->successResponse(null, 'Logged out successfully');
    }

    public function user()
    {
        return $this->successResponse(new UserResource(auth()->user()));
    }
}

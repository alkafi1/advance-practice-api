<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Exception;

/**
 * @group Authentication
 *
 * APIs for user authentication
 */
class AuthController
{
    use ApiResponse;
    protected $authService;

    /**
     * AuthController constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     *
     * @bodyParam name string required The user's name. Example: John Doe
     * @bodyParam email string required The user's email. Example: john@example.com
     * @bodyParam password string required The user's password. Example: secret123
     * @bodyParam password_confirmation string required The password confirmation. Example: secret123
     *
     * @response 201 {
     *   "success": true,
     *   "message": "User registered successfully",
     *   "data": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "john@example.com",
     *       "created_at": "2024-02-02T12:34:56.000000Z"
     *   }
     * }
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        // register user
        $user = $this->authService->register($request->validated());
        return $this->successResponse(new UserResource($user), 'User registered successfully', 201);
    }

    /**
     * Login a user.
     *
     * @bodyParam email string required The user's email. Example: john@example.com
     * @bodyParam password string required The user's password. Example: secret123
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Login successful",
     *   "data": {
     *       "token": "eyJhbGciOiJIUzI1NiIsInR5..."
     *   }
     * }
     *
     * @response 401 {
     *   "success": false,
     *   "message": "Invalid credentials"
     * }
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // login user
        $result = $this->authService->login($request->validated());
        if ($result) {
            return $this->successResponse($result, 'Login successful');
        }
        return $this->errorResponse('Invalid credentials', 401);
    }

    /**
     * Logout the authenticated user.
     *
     * @authenticated
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Logged out successfully"
     * }
     *
     * @return JsonResponse
     */
    public function logout()
    {
        // logout user
        $this->authService->logout(auth()->user());
        return $this->successResponse(null, 'Logged out successfully');
    }

    /**
     * Get the authenticated user's details.
     *
     * @authenticated
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "john@example.com",
     *       "created_at": "2024-02-02T12:34:56.000000Z"
     *   }
     * }
     *
     * @return JsonResponse
     */
    public function user()
    {
        // get authenticated user
        return $this->successResponse(new UserResource(auth()->user()));
    }
}

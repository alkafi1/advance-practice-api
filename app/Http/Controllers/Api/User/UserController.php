<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // List users with search, sort, and filter 
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sortColumn = $request->query('sort_column', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');
        $filters = $request->except(['search', 'sort_column', 'sort_direction', 'page']);

        $users = $this->userService->getAllUsers($search, $sortColumn, $sortDirection, $filters);

        return $this->successResponse(new UserResource($users), 'Users retrieved successfully', 201);
    }

    // Show user details
    public function show($id)
    {
        return $this->userService->getUserById($id);
    }

    // Update user
    public function update(UpdateUserRequest $request, $id)
    {
        return $this->userService->updateUser($id, $request->validated());
    }

    // Delete user
    public function destroy($id)
    {
        return $this->userService->deleteUser($id);
    }
}

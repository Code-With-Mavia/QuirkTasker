<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Login user and issue token
    public function login(UserRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) 
        {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken($data['device_name'])->plainTextToken;

        return response()->json([
            'success' => true,
            'token'   => $token,
        ]);
    }

    // Get all users
    public function index()
    {
        try 
        {
            $users = $this->userService->showAllUsers();
            return UserResource::collection($users)->additional([ 'success' => true]);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch users',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Create user
    public function store(UserCreateRequest $request)
    {
        try 
        {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            $user = $this->userService->createUsers($data);

            return new UserResource($user);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Show single user
    public function show($id)
    {
        try 
        {
            $user = $this->userService->findUsers($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }

            return new UserResource($user);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch user',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Update user
    public function update(UserUpdateRequest $request, $id)
    {
        try 
        {
            $data = $request->validated();

            if (isset($data['password'])) 
            {
                $data['password'] = Hash::make($data['password']);
            }

            $user = $this->userService->updateUsers($id, $data);

            if (!$user) 
            {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found or update failed',
                ], 404);
            }

            return new UserResource($user);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Delete user
    public function destroy($id)
    {
        try 
        {
            $deleted = $this->userService->deleteUsers($id);

            if (!$deleted) 
            {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found or already deleted',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully',
            ]);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
?>
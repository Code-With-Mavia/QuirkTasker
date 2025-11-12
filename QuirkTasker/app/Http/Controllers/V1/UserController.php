<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     * GET api/users/
     */
    public function index()
    {
        try
        {
            $users = $this->userService->showAllUsers();
            return response()->json(['success' => true, 'data' => $users], 200);
        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tasks',
                'error' => $e->getMessage()
            ], 404);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     * POST v1/api/users/
     */
    public function store(UserCreateRequest $request)
    {
        try
        {
            $user = $this->userService->createUsers($request->validated());
            $user['password'] = Hash::make($request->validated(['password']));
            return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User created successfully'
        ], 201);
        }
        catch (Exception $e)
        {
            return response()->json([
            'success' => false,
            'message' => 'Failed to create user',
            'error' => $e->getMessage()
        ], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try 
        {
            $user = $this->userService->findUsers($id);
            return response()->json([
                'success'=> true,
                'data'=> $user,
                'message'=> 'User created successfully',
                ],200);
        }
        catch (Exception $e)
        {
            return response()->json([
                'success'=> false,
                'message'=> 'user creation failed',
                'error'=> $e->getMessage()
                ], 404);
        }
    }

    /**
     * Update the specified user in storage.
     * PUT/PATCH api/users/{id}
     */
    public function update(UserUpdateRequest $request, $id)
    {
        try 
        {

            // Hash password if present
            if (isset($validated['password'])) 
            {
                $validated['password'] = Hash::make($request->validated(['password']));
            }

            // Update user through service
            $user = $this->userService->updateUsers($id, $request->validated());

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'User updated successfully',
            ], 200);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user',
                'error' => $e->getMessage()
            ], 403);
        }
    }


    /**
     * Remove the specified user from storage.
     * DELETE api/users/{id}
     */
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
                ], 403);
            }
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully',
            ], 200);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user',
                'error' => $e->getMessage()
            ], 403);
        }
    }
}

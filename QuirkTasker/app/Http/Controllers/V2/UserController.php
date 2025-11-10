<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Interfaces\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
    *   POST api/login 
    *   the function will process an check if users exist & if it exists it will generate a jwt bearer token 
    *   and with that the middleware can work through all the routes by authenticating amd then displaying the results 
    */
   public function login(Request $request)
    {
        // Log the attempt (but NEVER log raw passwords)
        Log::info('Login attempt', [
            'email' => $request->email,
            'time' => now()->toDateTimeString(),
            'ip' => $request->ip(),
        ]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|password',
            'device_name' => 'required|device_name',
        ]);
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) 
        {
            Log::error('Login failed', [
                'email' => $request->email,
                'reason' => 'Invalid credentials',
                'time' => now()->toDateTimeString(),
                'ip' => $request->ip(   ),
            ]);
            return response()->json(['error' => 'The provided credentials are incorrect.'], 401);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;
        Log::info('Login successful', [
            'user_id' => $user->id,
            'email' => $user->email,
            'time' => now()->toDateTimeString(),
            'ip' => $request->ip(),
            'device' => $request->device_name
        ]);
        return response()->json([ 'token' => $token ]);
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
     * POST api/v2/users/
     */
    public function store(Request $request)
    {
        try
        {
            $validated = $request->validate([
                'username'=>'required|string|max:50',
                'email'=>'required|string|unique:users,email|max:128',
                'password'=> 'required|string|min:8',
            ]);
            $validated['password'] = Hash::make($validated['password']);
            $user = $this->userService->createUsers($validated);
            return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User created successfully'
            ], 201);
        }
        catch (Exception $e) 
        {
            Log::error('Failed to create user', [
                'success' => false,
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ],403);
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
                ], 401);
        }
    }

    /**
     * Update the specified user in storage.
     * PUT/PATCH api/users/{id}
     */
    public function update(Request $request, $id)
    {
        try 
        {
            $validated = $request->validate([
                'username' => 'sometimes|string|max:50',
                'email' => 'sometimes|string|max:128',
                // Optional password field
                'password' => 'sometimes|string|min:8', 
            ]);

            // Hash password if present
            if (isset($validated['password'])) 
            {
                $validated['password'] = Hash::make($validated['password']);
            }

            // Update user through service
            $user = $this->userService->updateUsers($id, $validated);

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
            ], 401);
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
            ], 401);
        }
    }
}

?>
<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\TaskController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\ActivityLoggerController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1/tasks')->group(function () {
    // List all tasks
    Route::get('/', [TaskController::class, 'index']); 
    // Create task        
    Route::post('/', [TaskController::class, 'store']);  
    // List tasks by ID    
    Route::get('/{id}', [TaskController::class, 'show']);  
    // Update task  
    Route::put('/{id}', [TaskController::class, 'update']);  
    // Delete task
    Route::delete('/{id}', [TaskController::class, 'destroy']); 
});

Route::prefix('v1/users')->group(function () {
    // List all users
    Route::get('/', [UserController::class, 'index']);
    // Create user         
    Route::post('/', [UserController::class, 'store']);  
    // Get user by ID      
    Route::get('/{id}', [UserController::class, 'show']);  
    // Update user  
    Route::put('/{id}', [UserController::class, 'update']); 
    // Delete user 
    Route::delete('/{id}', [UserController::class, 'destroy']); 
});

Route::prefix('v1/logger')->group(function () {
    // List all Activity logs
    Route::get('/', [ActivityLoggerController::class,'index']);
    // Get Activity logs by ID
    Route::get('/{id}', [ActivityLoggerController::class,'show']);
});
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
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// V1 API CLASSES //
use App\Http\Controllers\V1\TaskController as TaskControllerV1;
use App\Http\Controllers\V1\UserController as UserControllerV1;
use App\Http\Controllers\V1\ActivityLoggerController as ActivityLoggerControllerV1;

// V2 API CLASSES //
use App\Http\Controllers\V2\TaskController as TaskControllerV2;
use App\Http\Controllers\V2\UserController as UserControllerV2;
use App\Http\Controllers\V2\ActivityLoggerController as ActivityLoggerControllerV2;

Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    return $request->user();
});



// v1 routes //

Route::prefix('v1')->group(function () {

    Route::prefix('tasks')->group(function () {
        // List all tasks
        Route::get('/', [TaskControllerV1::class, 'index']); 
        // Create task        
        Route::post('/', [TaskControllerV1::class, 'store']);  
        // List tasks by ID    
        Route::get('/{id}', [TaskControllerV1::class, 'show']);  
        // Update task  
        Route::put('/{id}', [TaskControllerV1::class, 'update']);  
        // Delete task
        Route::delete('/{id}', [TaskControllerV1::class, 'destroy']); 
    });

    Route::prefix('users')->group(function () {
            // List all users
            Route::get('/', [UserControllerV1::class, 'index']);
            // Create user         
            Route::post('/', [UserControllerV1::class, 'store']);  
            // Get user by ID      
            Route::get('/{id}', [UserControllerV1::class, 'show']);  
            // Update user  
            Route::put('/{id}', [UserControllerV1::class, 'update']); 
            // Delete user 
            Route::delete('/{id}', [UserControllerV1::class, 'destroy']); 
        })->middleware(['isVerified']);

    Route::prefix('logger')->group(function () {
        // List all Activity logs
        Route::get('/', [ActivityLoggerControllerV1::class,'index']);
        // Get Activity logs by ID
        Route::get('/{id}', [ActivityLoggerControllerV1::class,'show']);
    });

});

// v2 routes //

Route::post('/login', [UserControllerV2::class, 'login']); 

Route::prefix('v2')->middleware(['auth:sanctum', 'restrictRole'])->group(function () {
    // USERS (protected)
    Route::prefix('users')->group(function () {
        Route::get('/', [UserControllerV2::class, 'index']);
        Route::post('/', [UserControllerV2::class, 'store']);
        Route::get('/{id}', [UserControllerV2::class, 'show']);
        Route::put('/{id}', [UserControllerV2::class, 'update']);
        Route::delete('/{id}', [UserControllerV2::class, 'destroy']);
    });

    // TASKS (protected)
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskControllerV2::class, 'index']);
        Route::post('/', [TaskControllerV2::class, 'store']);
        Route::get('/{id}', [TaskControllerV2::class, 'show']);
        Route::put('/{id}', [TaskControllerV2::class, 'update']);
        Route::delete('/{id}', [TaskControllerV2::class, 'destroy']);
    });

    // LOGGER (protected)
    Route::prefix('logger')->group(function () {
        Route::get('/', [ActivityLoggerControllerV2::class, 'index']);
        Route::get('/{id}', [ActivityLoggerControllerV2::class, 'show']);
        Route::put('/{id}', [ActivityLoggerControllerV2::class,'update']);
        Route::delete('/{id}', [ActivityLoggerControllerV2::class,'destroy']);
    });
});





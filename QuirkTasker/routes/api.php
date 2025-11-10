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

// V1 API CLASSES //
// use App\Http\Controllers\V1\TaskController;
// use App\Http\Controllers\V1\UserController;
// use App\Http\Controllers\V1\ActivityLoggerController;

// V2 API CLASSES //
use App\Http\Controllers\V2\TaskController;
use App\Http\Controllers\V2\UserController;
use App\Http\Controllers\V2\ActivityLoggerController;

// Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
//     return $request->user();
// });



// v1 routes //

// Route::prefix('v1')->group(function () {

//     Route::prefix('tasks')->group(function () {
//         // List all tasks
//         Route::get('/', [TaskController::class, 'index']); 
//         // Create task        
//         Route::post('/', [TaskController::class, 'store']);  
//         // List tasks by ID    
//         Route::get('/{id}', [TaskController::class, 'show']);  
//         // Update task  
//         Route::put('/{id}', [TaskController::class, 'update']);  
//         // Delete task
//         Route::delete('/{id}', [TaskController::class, 'destroy']); 
//     });

//     Route::prefix('users')->group(function () {
//             // List all users
//             Route::get('/', [UserController::class, 'index']);
//             // Create user         
//             Route::post('/', [UserController::class, 'store']);  
//             // Get user by ID      
//             Route::get('/{id}', [UserController::class, 'show']);  
//             // Update user  
//             Route::put('/{id}', [UserController::class, 'update']); 
//             // Delete user 
//             Route::delete('/{id}', [UserController::class, 'destroy']); 
//         })->middleware(['isVerified']);

//     Route::prefix('logger')->group(function () {
//         // List all Activity logs
//         Route::get('/', [ActivityLoggerController::class,'index']);
//         // Get Activity logs by ID
//         Route::get('/{id}', [ActivityLoggerController::class,'show']);
//     });

// });


Route::post('/login', [UserController::class, 'login']); 

Route::prefix('v2')->middleware(['auth:sanctum', 'restrictRole'])->group(function () {
    // USERS (protected)
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    // TASKS (protected)
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::get('/{id}', [TaskController::class, 'show']);
        Route::put('/{id}', [TaskController::class, 'update']);
        Route::delete('/{id}', [TaskController::class, 'destroy']);
    });

    // LOGGER (protected)
    Route::prefix('logger')->group(function () {
        Route::get('/', [ActivityLoggerController::class, 'index']);
        Route::get('/{id}', [ActivityLoggerController::class, 'show']);
    });
});





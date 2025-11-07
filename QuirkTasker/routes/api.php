<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\V1\TaskController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\ActivityLoggerController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('tasks')->group(function () {
    // GET api/v1/tasks
    Route::get('/',[TaskController::class,'index']);
    // GET api/v1/tasks/{id}
    Route::get('/{id}',[TaskController::class,'find']);
    // POST api/v1/tasks/
    Route::post('/',[TaskController::class,'store']);
    // PUT api/v1/tasks/{id}
    Route::put('/{id}',[TaskController::class,'update']);
    // DELETE api/v1/tasks/{id}
    Route::delete('/{id}',[TaskController::class,'delete']);

});
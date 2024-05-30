<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\taskController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tasks', [taskController::class, 'index']);

Route::get('/task/{id}', [taskController::class, 'getTask']);

Route::post('/task', [taskController::class, 'createTask']);

Route::put('/task/{id}', [taskController::class, 'updateTask']);

Route::patch('/task/{id}', [taskController::class, 'updatePartialTask']);

Route::delete('/task/{id}', [taskController::class, 'deleteTask']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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
// all route of todo
Route::post('/tasks', [TodoController::class, 'store']);
Route::get('/tasks-details', [TodoController::class, 'getTasksDetails']);
Route::delete('/tasks/{id}', [TodoController::class, 'deleteTask']);
Route::delete('/tasks', [TodoController::class, 'deleteAllTasks']);
Route::put('/tasks/{id}', [TodoController::class, 'update']);
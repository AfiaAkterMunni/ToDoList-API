<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//---------------------------------------------------------//
//----------------------------Auth------------------------//
//---------------------------------------------------------//
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function(){

    Route::get('/me', [AuthController::class, 'me']);
});

//---------------------------------------------------------//
//-------------------------Categories----------------------//
//---------------------------------------------------------//

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/selected', [CategoryController::class, 'select']);
Route::post('/categories/store', [CategoryController::class, 'store']);
Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete']);


//---------------------------------------------------------//
//----------------------------Tasks------------------------//
//---------------------------------------------------------//

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks/store', [TaskController::class, 'store']);
Route::put('/tasks/update/{id}', [TaskController::class, 'update']);
Route::put('/tasks/statusupdate/{id}', [TaskController::class, 'statusUpdate']);
Route::delete('/tasks/delete/{id}', [TaskController::class, 'delete']);


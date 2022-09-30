<?php

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
//-------------------------Categories----------------------//
//---------------------------------------------------------//

Route::post('/categories/store', [CategoryController::class, 'store']);
Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete']);

//---------------------------------------------------------//
//----------------------------Tasks------------------------//
//---------------------------------------------------------//
Route::post('/tasks/store', [TaskController::class, 'store']);
Route::put('/tasks/update/{id}', [TaskController::class, 'update']);
Route::put('/tasks/statusupdate/{id}', [TaskController::class, 'statusUpdate']);
Route::delete('/tasks/delete/{id}', [TaskController::class, 'delete']);

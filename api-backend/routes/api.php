<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KudoController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);

Route::group([
  'middleware' => 'auth:api'
], function() {
    Route::get('logout', 'AuthController@logout');
    Route::get('users', 'UserController@users');

    Route::get('/kudos', [KudoController::class, 'list']);
    Route::post('/add-kudo', [KudoController::class, 'save']);
    Route::get('/kudos/{id}', [KudoController::class, 'getKudoById']);
    Route::post('/add-card', [KudoController::class, 'saveCard']);
    Route::get('/kudo-card/{id}', [KudoController::class, 'getKudoCardById']);
});

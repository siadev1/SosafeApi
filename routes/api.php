<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\biodataController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\authenticationController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\MissingWantedController;
use App\Http\Controllers\NewsController;


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
Route::post('register', [authenticationController::class, 'register']);
Route::post('login', [authenticationController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/data',[biodataController::class, 'getdata']);
    Route::get('user', [authenticationController::class, 'getUser']);
    Route::post('logout', [authenticationController::class, 'logout']);
    // news controller
    Route::post('news', [NewsController::class, 'storeNews']);
    Route::put('news/{id}', [NewsController::class, 'editNews']);
    Route::get('news', [NewsController::class, 'getNews']);
    Route::delete('news/{id}',[NewsController::class,'deleteNews']);

    // missing/wanted controller
    Route::post('missing', [MissingWantedController::class, 'storeNews']);
    Route::put('Missing/{id}', [MissingWantedController::class, 'editMissing']);
    Route::get('Missing', [MissingWantedController::class, 'getMissing']);
    Route::delete('Missing/{id}',[MissingWantedController::class,'deleteMissing']);

    // hero controller
    Route::post('hero', [HeroController::class, 'storeNews']);
    Route::put('Hero/{id}', [HeroController::class, 'editHero']);
    Route::get('Hero', [HeroController::class, 'getHero']);
    Route::delete('Hero/{id}',[HeroController::class,'deleteHero']);

});


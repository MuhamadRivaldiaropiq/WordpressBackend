<?php

use App\Models\Wordpress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\WordpressController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Article;

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


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('wordpress/wordpress-by-id/{id}',[WordpressController::class,'getDataById']);

Route::resource('users', UserController::class);

Route::post('wordpress/updatetoken/{id}', [WordpressController::class, 'updateToken']);
Route::resource('wordpress', WordpressController::class);


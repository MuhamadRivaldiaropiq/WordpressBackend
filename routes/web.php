<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // $response = Http::get('http://contoh2.test/wp-json/wp/v2/tags');
    $response = Http::get('http://contoh2.test/wp-json/wp/v2/tags?search=content');
    $json = $response->getBody()->getContents();
    $status = $response->getStatusCode();
    $json = json_decode($json);
    $json = $json[0];
    $id = $json->name;

    dd($id);
    // return ['Laravel' => app()->version()];
});
// Route::get('articles', [ArticleController::class, 'store']);


require __DIR__.'/auth.php';

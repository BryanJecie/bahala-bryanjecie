<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace' => '\app'], function () {
    foreach (scandir($basePath = base_path('app/Domains')) as $directory) {
        if (file_exists($apiPath = "{$basePath}/{$directory}/Routes/api.php")) {
            include $apiPath;
        }
    }
});

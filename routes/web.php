<?php

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

Route::domain(\App\Libs\BACKEND_DOMAIN)->group(function () {
    include 'admin.php';
});

Route::domain(\App\Libs\FRONT_DOMAIN)->group(function () {
    include 'front.php';
});

Route::post('/upload-image', 'Common\UploadController@uploadImage');

Route::get('/test', 'TestController@index');

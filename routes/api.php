<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['auth:api','IsReader'])->get('/user', function (Request $request) {
    return response()->json(array('status' => 'success', 'data' => Auth::user()));
});

Route::middleware(['auth:api','IsReader'])->resource('blog', 'Api\BlogController');

Route::middleware(['auth:api','IsWriter'])->resource('blog-manager', 'Api\BlogManagerController');

Route::middleware(['auth:api','IsAdmin'])->resource('user-manager', 'Api\UserManagerController');

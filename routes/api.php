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

Route::post('/auth/login', 'Api\UserController@login');

Route::middleware(['IsLoggedIn'])->get('/auth/user', 'Api\UserController@userInfo');

Route::middleware(['IsLoggedIn','IsReader'])->resource('blog', 'Api\BlogController');

Route::middleware(['IsLoggedIn','IsWriter'])->resource('blog-manager', 'Api\BlogManagerController');

Route::middleware(['IsLoggedIn','IsAdmin'])->resource('user-manager', 'Api\UserManagerController');

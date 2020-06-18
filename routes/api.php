<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/* ******** USER ROUTE ********  */

// Normal user
Route::post('/auth/login', 'Api\UserController@login');
Route::middleware(['IsLoggedIn'])->get('/auth/user', 'Api\UserController@userInfo');
Route::middleware(['IsLoggedIn'])->get('/auth/logout', 'Api\UserController@logout');

// Admin
Route::middleware(['IsLoggedIn','IsAdmin'])->resource('user-manager', 'Api\UserManagerController');
/* ******** END USER ROUTE ********  */


/* ******** CATEGORY ROUTE ********  */
Route::middleware(['IsLoggedIn'])->get('/category', 'Api\CategoryController@index');
/* ******** END CATEGORY ROUTE ********  */

/* ******** BLOG ROUTE ********  */

Route::middleware(['IsLoggedIn','IsReader'])->resource('blog', 'Api\BlogController');
Route::middleware(['IsLoggedIn','IsReader'])->get('category/{id}', 'Api\BlogController@getBlogsByCategory');
Route::get('dummy', 'Api\BlogController@dummy');
Route::middleware(['IsLoggedIn','IsWriter'])->resource('blog-manager', 'Api\BlogManagerController');
/* ******** END BLOG ROUTE ********  */

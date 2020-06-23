<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/* ******** USER ROUTE ********  */
Route::post('/auth/login', 'Api\UserController@login');
Route::middleware(['IsLoggedIn'])->get('/auth/user', 'Api\UserController@userInfo');
Route::middleware(['IsLoggedIn'])->get('/auth/logout', 'Api\UserController@logout');

/* ******** END USER ROUTE ********  */


/* ******** CATEGORY ROUTE ********  */
Route::middleware(['IsLoggedIn'])->get('/category', 'Api\CategoryController@index');
/* ******** END CATEGORY ROUTE ********  */


/* ******** BLOG ROUTE ********  */
Route::middleware(['IsLoggedIn','IsReader'])->resource('blog', 'Api\BlogController');
Route::middleware(['IsLoggedIn','IsReader'])->get('blog-by-category/{id}', 'Api\BlogController@getBlogsByCategory');
//Route::get('dummy', 'Api\BlogController@dummy');
Route::get('search-blog', 'Api\BlogController@search');
Route::middleware(['IsLoggedIn','IsWriter'])->get('blog-manager', 'Api\BlogManagerController@index');
Route::middleware(['IsLoggedIn','IsWriter'])->post('blog-manager/save', 'Api\BlogManagerController@save');
Route::middleware(['IsLoggedIn','IsAdmin'])->get('blog-manager/delete/{id}', 'Api\BlogManagerController@delete');

Route::middleware(['IsLoggedIn'])->get('comment/{blog_id}', 'Api\CommentController@show');
Route::middleware(['IsLoggedIn'])->post('comment/{blog_id}', 'Api\CommentController@save');
/* ******** END BLOG ROUTE ********  */


/* ******** ADMIN USER MANAGER ROUTE ********  */
Route::middleware(['IsLoggedIn', 'IsAdmin'])->get('/user-manager/show/{id}', 'Api\UserManagerController@show');
Route::middleware(['IsLoggedIn', 'IsAdmin'])->post('/user-manager/save/', 'Api\UserManagerController@save');
Route::middleware(['IsLoggedIn', 'IsAdmin'])->post('/user-manager/create/', 'Api\UserManagerController@create');
Route::middleware(['IsLoggedIn', 'IsAdmin'])->get('/user-manager/', 'Api\UserManagerController@index');
Route::middleware(['IsLoggedIn', 'IsAdmin'])->get('/user-manager/delete/{id}', 'Api\UserManagerController@deleteUser');
Route::middleware(['IsLoggedIn', 'IsAdmin'])->get('/user-manager/search/', 'Api\UserManagerController@search');
/* ******** END CATEGORY ROUTE ********  */

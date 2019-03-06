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

Route::get('{local}/{slug}', 'SiteAPI\PostController@show');
Route::get('{local}/category/{cat1?}/{cat2?}/{cat3?}/{slug?}', 'SiteAPI\PostController@index');



Route::get('/all/{postType}', 'CMS\Posts\PostController@showAllPosts');
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


//Show Articles

Route::get('articles', 'ArticlesController@index');

//Show Article Detail

Route::get('/articles/{id}', 'ArticlesController@show');

//Create Article

Route::post('/articles','ArticlesController@store');

//update

Route::put('/articles','ArticlesController@store');

//delete

Route::delete('/articles/{id}','ArticlesController@destroy');
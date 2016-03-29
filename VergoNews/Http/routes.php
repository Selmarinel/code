<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(['as'=> 'api:', 'prefix' => '/api', 'middleware' => ['web']], function () {
	Route::get('/news', ['as' => 'news', 'uses' => 'ApiController@getAPINews']);
});

Route::group(['as' => 'site:article:', 'middleware' => ['webAdmin', 'UserAuthenticate']], function() {
	Route::get('/', ['as' => 'index', 'uses' => 'ArticlesController@getArticles']);
	Route::get('/page/{id}', ['as' => 'one', 'uses' => 'ArticlesController@getArticle']);
	Route::get('/category/{id}', ['as' => 'category', 'uses' => 'ArticlesController@getArticles']);
});

Route::group(['as' => 'site:', 'prefix' => '/', 'middleware' => ['web', 'UserAuth']], function () {
	Route::any('login', ['as' => 'login',  'uses' => 'Admin\UserController@login']);
	Route::get('logout', ['as' => 'logout',  'uses' => 'Admin\UserController@logout']);
});

Route::group(['as' => 'admin', 'prefix' => 'vadmin', 'middleware' => ['webAdmin']], function() {
	Route::group(['middleware' => 'AdminAuthenticate'], function(){
		Route::get('/', ['as' => ':index', 'uses' => 'Admin\ArticlesController@main']);
		Route::group(['prefix' => 'news'], function(){
			$asAction = ':news';
			Route::get('/', ['as' => $asAction . ':index', 'uses' => 'Admin\ArticlesController@index']);
			Route::any('/add', ['as' => $asAction.':add', 'uses' => 'Admin\ArticlesController@add']);
			Route::get('/{id}/active', ['as' => $asAction.':active', 'uses' => 'Admin\ArticlesController@active']);
			Route::any('{id}/delete', ['as' => $asAction.':delete', 'uses' => 'Admin\ArticlesController@delete']);
			Route::any('/{id}/edit', ['as' => $asAction.':edit', 'uses' => 'Admin\ArticlesController@edit']);
		});
		Route::group(['prefix' => 'categories'], function(){
			$asAction = ':categories';
			Route::get('/', ['as' => $asAction . ':index', 'uses' => 'Admin\CategoriesController@index']);
			Route::any('/{id}/edit', ['as' => $asAction .':edit', 'uses' => 'Admin\CategoriesController@edit']);
			Route::any('/add', ['as' => $asAction .':add', 'uses' => 'Admin\CategoriesController@add']);
			Route::get('/{id}/active', ['as' => $asAction.':active', 'uses' => 'Admin\CategoriesController@active']);
			Route::get('/{id}/delete', ['as' => $asAction.':delete', 'uses' => 'Admin\CategoriesController@delete']);
			Route::get('/{id}/update', ['as' => $asAction.':update', 'uses' => 'Admin\CategoriesController@update']);
		});
	});
});

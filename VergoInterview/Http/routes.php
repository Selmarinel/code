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

Route::group(['prefix' => 'vadmin', 'middleware' => ['webAdmin']], function() {
	$asPrefix = 'admin';
	Route::group(['middleware' => 'AdminAuthenticate'], function () use ($asPrefix) {
		Route::group(['prefix' => 'interview'], function () use ($asPrefix) {
			$asAction = ':interview';
			Route::post('/addCover',['as' => $asPrefix . $asAction . ':add:photo', 'uses' => 'Admin\InterviewController@addPhoto']);
			Route::delete('/deleteDialog/{id}',['as' => $asPrefix . $asAction . ':delete:dialog', 'uses' => 'Admin\InterviewController@deleteDialog']);
		});
	});
});
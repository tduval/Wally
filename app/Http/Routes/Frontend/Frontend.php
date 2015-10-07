<?php

/**
 * Frontend Controllers
 */
get('/', 'FrontendController@index')->name('home');
get('macros', 'FrontendController@macros');

/**
 * These frontend controllers require the user to be logged in
 */
$router->group(['middleware' => 'auth'], function () use ($router) {
	get('dashboard', 'DashboardController@index')->name('frontend.dashboard');
	get('profile/edit', 'ProfileController@edit')->name('frontend.profile.edit');
	patch('profile/update', 'ProfileController@update')->name('frontend.profile.update');

	get('stock', 'StockController@index')->name('frontend.stock');
	post('stock', 'StockController@postSearch')->name('frontend.stock');

	get('account', 'AccountController@index')->name('frontend.account');
	post('account', 'AccountController@createAccount')->name('frontend.account');

	$router->group(['prefix' => 'account/{id}', 'where' => ['id' => '[0-9]+']], function () use ($router) {
		get('view', 'AccountController@view')->name('frontend.account');
		get('delete', 'AccountController@delete')->name('frontend.account');
		post('add', 'AccountController@addTransaction')->name('frontend.account');
	});

});

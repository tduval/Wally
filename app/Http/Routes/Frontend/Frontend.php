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

	get('portfolio', 'PortfolioController@index')->name('frontend.portfolio');
	post('account', 'AccountController@createAccount')->name('frontend.account');

	$router->group(['prefix' => 'account/{id}', 'where' => ['id' => '[0-9]+']], function ($id) use ($router) {
		get('/', 'AccountController@index')->name('frontend.account');
		get('delete', 'AccountController@deleteAccount')->name('frontend.account');
		post('/', 'AccountController@addTransaction')->name('frontend.account');
		post('cash', 'AccountController@cash')->name('frontend.account');
		get('/transaction/{idtransaction}/delete', 'AccountController@deleteTransaction')->where(['idtransaction' => '[0-9]+']);
	});

});

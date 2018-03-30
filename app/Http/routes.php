<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/create', function(){
//    Corp\User::create([
//        'name' => 'SomeName',
//        'email' => 'SomeEmail',
//        'login' => 'SomeLogin',
//        'password' => bcrypt('SomePassword'),
//    ]);
// });

Route::resource('/','IndexController',[
					'only' => ['index'],
					'names' => [
							'index'=>'home'
						]
						]);

Route::resource('portfolios','PortfolioController',[
													
													'parameters' => [
													
														'portfolios' => 'alias'
													
													]
													
													]);

Route::resource('articles','ArticlesController',[

				'parameters' => [

					'articles' => 'alias'

				]

				]);

Route::get('articles/cat/{cat_alias?}',['uses'=>'ArticlesController@index','as'=>'articlesCat'])->where('cat_alias','[\w-]+');

Route::get('portfolios/filter/{filter_alias?}',['uses'=>'PortfolioController@index','as'=>'portfoliosFilter'])->where('filter_alias','[\w-]+');

Route::resource('comment','CommentController',['only'=>'store']);

Route::match(['get','post'],'/contacts',['uses'=>'ContactsController@index','as'=>'contacts']);

//ранее была выполнена команда php artisan make:auth, но сформированные макеты нам не нужны, будем делать свои,
// поэтому удаляем всю папку /resources/view/auth/
Route::get('login','Auth\AuthController@showLoginForm');
Route::post('login','Auth\AuthController@login');
Route::get('logout','Auth\AuthController@logout');

// admin
Route::group(['prefix'  => 'admin','middleware' => 'auth'], function() {
	// admin
	Route::get('/',['uses' => 'Admin\IndexController@index', 'as' => 'adminIndex']);
	Route::resource('/articles', 'Admin\ArticlesController');
	Route::resource('/categories', 'Admin\CategoriesController');
	Route::resource('/portfolios', 'Admin\PortfoliosController');
	Route::resource('/filters', 'Admin\FiltersController');
	Route::resource('/permissions', 'Admin\PermissionsController');
	Route::resource('/users', 'Admin\UsersController');
	Route::resource('/menus', 'Admin\MenusController');


});
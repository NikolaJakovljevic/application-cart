<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'frontend\HomeController@index')->name('home');
Route::resource('tables', 'frontend\TablesController');
Route::post('tableDetails', 'frontend\TablesController@tableDetails');
Route::post('getSubcategories', 'frontend\TablesController@getSubcategories');
Route::post('getProducts', 'frontend\TablesController@getProducts');

Route::post('addProductOrder', 'frontend\TablesController@addProductOrder');
Route::post('changeItems', 'frontend\TablesController@changeItems');


Route::post('discount', 'frontend\DiscountController@index');
Route::post('calculateDiscount', 'frontend\DiscountController@calculateDiscount');

Route::post('cancellationItems', 'frontend\CancellationController@cancellationItems');
Route::post('cash', 'frontend\CashController@cash');
Route::post('payment', 'frontend\CashController@payment');

Route::post('repeatOrder', 'frontend\OrderProductController@index');


Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Auth::routes();

Route::get('/home', 'frontend\HomeController@index')->name('home');

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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

// 4. Available Car Information
Route::get('cars/free/date={date}', 'RentalController@getAvailableCars');
// 5. Rented Car Information
Route::get('cars/rented/date={date}', 'RentalController@getRentedCars');
// 6. Client Rental History
Route::get('histories/client/{id}', 'RentalController@getClientHistory');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//1. RESTful Resource Client Controller
Route::resource('clients', 'ClientController');
//2. RESTful Resource Car Controller
Route::resource('cars', 'CarController');
//3. RESTful Resource Rental Controller
Route::resource('rentals', 'RentalController');

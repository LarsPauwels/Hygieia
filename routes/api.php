<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
	Route::post('login', 'AuthController@login')->name('login');
	Route::put('change', 'AuthController@changePassword');
	Route::put('forgot', 'AuthController@forgotPassword');

	Route::group(['middleware' => 'auth:api'], function() {
		Route::get('logout', 'AuthController@logout');

		// User end-points
		Route::middleware('can:isAdmin')->group(function() {
			Route::get('user/list', 'UserController@getUsers');
			Route::get('user/clients', 'UserController@getUserClients');
			Route::get('user/products', 'UserController@getUserProducts');
		});

		// Client end-points
		Route::middleware('can:isAdmin')->group(function() {
			Route::get('client/list', 'ClientController@getClients');
			Route::get('client/{id}', 'ClientController@getClientById');
			Route::post('client', 'ClientController@createClient');
			Route::put('client/{id}', 'ClientController@updateClientById');
			Route::delete('client/{id}', 'ClientController@deleteClientById');

			Route::put('client/{id}/payed', 'ClientController@updateClientPay');
			Route::put('client/{id}/expired', 'ClientController@updateClientExpire');
		});

		Route::get('client/{id}/pdf', 'ClientController@generatePDF');
		Route::get('client/{id}/tabel/{year}/{month}', 'ClientController@generateTable');
		Route::get('client/{id}/tabels/{year}', 'ClientController@generateTables');

		// Icon end-points
		Route::get('icon/list', 'IconController@getIcons');
		Route::get('icon/{id}', 'IconController@getIconById');

		Route::middleware('can:isAdmin')->group(function() {
			Route::post('icon', 'IconController@createIcon');
			Route::put('icon/{id}', 'IconController@updateIconById');
			Route::delete('icon/{id}', 'IconController@deleteIconById');
		});

		// Procedure end-points
		Route::get('procedure/list', 'ProcedureController@getProcedures');
		Route::get('procedure/{id}', 'ProcedureController@getProcedureById');
		
		Route::middleware('can:isAdmin')->group(function() {
			Route::post('procedure', 'ProcedureController@createProcedure');
			Route::put('procedure/{id}', 'ProcedureController@updateProcedureById');
			Route::delete('procedure/{id}', 'ProcedureController@deleteProcedureById');
		});

		//Space end-points
		Route::get('client/{id}/space/list', 'SpaceController@getSpaces');
		Route::get('space/{id}', 'SpaceController@getSpaceById');
		Route::post('client/{id}/space', 'SpaceController@createSpace');
		Route::put('space/{id}', 'SpaceController@updateSpaceById');
		Route::delete('space/{id}', 'SpaceController@deleteSpaceById');

		//Item end-points
		Route::get('space/{id}/item/list', 'ItemController@getItems');
		Route::get('item/{id}', 'ItemController@getItemById');
		Route::post('space/{id}/item', 'ItemController@createItem');
		Route::put('item/{id}', 'ItemController@updateItemById');
		Route::delete('item/{id}', 'ItemController@deleteItemById');

		Route::get('item/{id}/product', 'ItemController@getItemProduct');
		Route::post('item/{id}/product', 'ItemController@createItemProduct');
		Route::delete('item/{id}/product', 'ItemController@deleteItemProduct');

		// Product end-points
		Route::get('product/list', 'ProductController@getProducts');
		Route::get('product/{id}', 'ProductController@getProductById');

		Route::middleware('can:isAdmin')->group(function() {
			Route::post('product', 'ProductController@createProduct');
			Route::put('product/{id}', 'ProductController@updateProductById');
			Route::delete('product/{id}', 'ProductController@deleteProductById');
		});

		// Frequency end-points
		Route::get('frequency/list', 'FrequencyController@getFrequencies');
		Route::get('frequency/{id}', 'FrequencyController@getFrequencyById');

		Route::middleware('can:isAdmin')->group(function() {
			Route::post('frequency', 'FrequencyController@createFrequency');
			Route::put('frequency/{id}', 'FrequencyController@updateFrequencyById');
			Route::delete('frequency/{id}', 'FrequencyController@deleteFrequencyById');
		});
	});
});

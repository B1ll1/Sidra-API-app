<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('products.index');
});

Route::post('/importar',['as'=>'import', 'uses'=>'ImportController@Import']);

Route::group(['prefix' => 'producao', 'as' => 'product-region-type.'], function() {
    Route::get('', ['as' => 'index', 'uses' => 'ProductRegionTypesController@index']);
    Route::get('datatables', ['as' => 'indexDataTables', 'uses' => 'ProductRegionTypesController@indexDataTables']);
    Route::get('cadastrar', ['as' => 'create', 'uses' => 'ProductRegionTypesController@create']);
    Route::post('salvar', ['as' => 'store', 'uses' => 'ProductRegionTypesController@store']);
});
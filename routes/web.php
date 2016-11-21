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
    return redirect()->route('product-region-type.index');
});

Route::post('/importar',['as'=>'import', 'uses'=>'ImportController@Import']);

Route::group(['prefix' => 'producao', 'as' => 'product-region-type.'], function() {
    Route::get('estados', ['as' => 'index', 'uses' => 'ProductRegionTypesController@index']);
    Route::get('regiao', ['as' => 'bigRegion', 'uses' => 'ProductRegionTypesController@bigRegion']);
    Route::get('pais', ['as' => 'country', 'uses' => 'ProductRegionTypesController@country']);

    Route::group(['middleware' => 'auth'], function() {
        Route::get('cadastrar', ['as' => 'create', 'uses' => 'ProductRegionTypesController@create']);
        Route::post('salvar', ['as' => 'store', 'uses' => 'ProductRegionTypesController@store']);
        Route::get('{productionId}/editar', ['as' => 'edit', 'uses' => 'ProductRegionTypesController@edit']);
        Route::put('{productionId}/alterar', ['as' => 'update', 'uses' => 'ProductRegionTypesController@update']);
        Route::delete('{productionId}/deletar', ['as' => 'destroy', 'uses' => 'ProductRegionTypesController@destroy']);
    });

    Route::get('datatables', ['as' => 'indexDataTables', 'uses' => 'ProductRegionTypesController@indexDataTables']);
    Route::get('datatables2', ['as' => 'bigRegionDataTables', 'uses' => 'ProductRegionTypesController@bigRegionDataTables']);
    Route::get('datatables3', ['as' => 'countryDataTables', 'uses' => 'ProductRegionTypesController@countryDataTables']);
});

Route::group(['prefix' => 'analise', 'as' => 'report.'], function() {
    Route::get('', ['as' => 'index', 'uses' => 'ReportsController@index']);
    Route::post('relatorio', ['as' => 'generateReport', 'uses' => 'ReportsController@generateReport']);

    Route::get('estado', ['as' => 'productionForRegionChart', 'uses' => 'ReportsController@productionForRegionChart']);
    Route::get('producao-por-regiao/dados', ['as' => 'productionForRegionChartData', 'uses' => 'ReportsController@productionForRegionChartData']);

    Route::get('grande-regiao', ['as' => 'productionForBigRegionChart', 'uses' => 'ReportsController@productionForBigRegionChart']);
    Route::get('producao-por-grande-regiao/dados', ['as' => 'productionForBigRegionChartData', 'uses' => 'ReportsController@productionForBigRegionChartData']);

    Route::get('pais', ['as' => 'productionForCountryChart', 'uses' => 'ReportsController@productionForCountryChart']);
    Route::get('producao-por-pais/dados', ['as' => 'productionForCountryChartData', 'uses' => 'ReportsController@productionForBigRegionChartData']);
});

Auth::routes();
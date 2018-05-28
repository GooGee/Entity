<?php

// Entity
Route::group(['namespace' => 'GooGee\\Entity'], function () {
    Route::get('entity', 'EntityController@index');
    Route::get('entity/load', 'EntityController@load');
    Route::post('entity', 'EntityController@store');
    Route::post('entity/table', 'EntityController@table');
    Route::post('entity/model', 'EntityController@model');
    Route::post('entity/factory', 'EntityController@factory');
    Route::post('entity/controller', 'EntityController@controller');
    Route::post('entity/form', 'EntityController@form');
});

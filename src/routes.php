<?php

// Entity
Route::group(['namespace' => 'GooGee\\Entity'], function () {
    Route::get('entity', 'EntityController@index');
    Route::post('entity', 'EntityController@store');
    Route::post('entity/table', 'EntityController@table');
    Route::post('entity/model', 'EntityController@model');
    Route::post('entity/controller', 'EntityController@controller');
    Route::post('entity/form', 'EntityController@form');

    Route::get('entity/publish', 'EntityController@publish');
});

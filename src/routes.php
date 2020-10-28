<?php

Route::group(['namespace' => 'GooGee\\Entity', 'middleware' => []], function () {
    Route::get('entity', 'EntityController@load');
    Route::post('entity', 'EntityController@save');
    Route::post('entity/code', 'EntityController@deploy');
    Route::post('entity/run', 'EntityController@run');
    Route::get('entity/table', 'EntityController@table');
});

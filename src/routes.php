<?php

Route::group(['namespace' => 'GooGee\\Entity'], function () {
    Route::get('entity', 'EntityController@load');
    Route::post('entity', 'EntityController@save');
    Route::post('entity/code', 'EntityController@deploy');
    Route::get('entity/table', 'EntityController@table');
});

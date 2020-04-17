<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Niaz\DBpanel\Http\Controllers'], function () {
    Route::get('/dbpanel','DBpanelController@index');
    Route::any('/dbpanel/{table}/{jointable?}','DBpanelController@data');
});
<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Niaz\DBpanel\Http\Controllers'], function () {
    Route::get('/dbpanel','DBpanelController@index');
    Route::any('/dbpanel/database/{table}/{jointable?}','DBpanelController@data');
    Route::get('/dbpanel/controller/{controller}','DBpanelController@checkController');
});
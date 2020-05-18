<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Niaz\DBpanel\Http\Controllers'], function () {
    Route::get('/dbpanel','DBpanelController@index');
    Route::any('/dbpanel/database/{table}/{jointable?}','DBpanelController@data');
    Route::get('/dbpanel/controller/{controller}','DBpanelController@checkController');
    Route::get('/dbpanel/model/{model}','DBpanelController@checkModel');
    Route::get('/dbpanel/other/{other}','DBpanelController@checkOther');
    Route::get('/dbpanel/command/{other}','DBpanelController@run');
});
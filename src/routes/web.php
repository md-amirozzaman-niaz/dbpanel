<?php

use Illuminate\Support\Facades\Route;
use Niaz\DBpanel\Http\Controllers\DBpanelController;

Route::group(['namespace' => 'Niaz\DBpanel\Http\Controllers'], function () {
    Route::get('/dbpanel', [DBpanelController::class,'index']);
    Route::any('/dbpanel/database/{table}', [DBpanelController::class,'data']);
    Route::get('/dbpanel/route', [DBpanelController::class,'checkRoute']);
    Route::get('/dbpanel/controller/{controller}', [DBpanelController::class,'checkController']);
    Route::get('/dbpanel/model/{model}', [DBpanelController::class,'checkModel']);
    Route::get('/dbpanel/other/{other}', [DBpanelController::class,'checkOther']);
    Route::get('/dbpanel/command/{other}', [DBpanelController::class,'run']);
    Route::get('/dbpanel/save', [DBpanelController::class,'save']);
    Route::get('/dbpanel/load', [DBpanelController::class,'load']);
    Route::get('/dbpanel/doc', [DBpanelController::class,'doc']);
    Route::get('/__open-in-editor', [DBpanelController::class,'openFile']);
});

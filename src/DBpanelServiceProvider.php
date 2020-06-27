<?php

namespace Niaz\DBpanel;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;

class DBpanelServiceProvider extends ServiceProvider{

    public function boot(){
    
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'dbpanel');
        $this->mergeConfigFrom(
            __DIR__.'/config/dbpanel.php', 'dbpanel'
        );
        $this->publishes([
            __DIR__.'/config/dbpanel.php' => config_path('dbpanel.php')
        ], 'dbpanel');
        $this->publishes([
            __DIR__.'/public' => public_path('vendor/dbpanel'),
        ], 'dbpanel');
    }

    public function register(){

    }
}
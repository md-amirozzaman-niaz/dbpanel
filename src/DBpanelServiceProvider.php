<?php

namespace Niaz\DBpanel;

use Illuminate\Support\ServiceProvider;

class DBpanelServicePorvider extends ServiceProvider{

    public function boot(){
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'dbpanel');
        $this->mergeConfigFrom(
            __DIR__.'/config/dbpanel.php', 'dbpanel'
        );
    }

    public function register(){

    }
}
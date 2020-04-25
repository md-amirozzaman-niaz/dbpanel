<?php

namespace Niaz\DBpanel;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;

class DBpanelServiceProvider extends ServiceProvider{

    public function boot(){
        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        // Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
        //     $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

        //     return new LengthAwarePaginator(
        //         $this->forPage($page, $perPage),
        //         $total ?: $this->count(),
        //         $perPage,
        //         $page,
        //         [
        //             'path' => LengthAwarePaginator::resolveCurrentPath(),
        //             'pageName' => $pageName,
        //         ]
        //     );
        // });
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'dbpanel');
        $this->mergeConfigFrom(
            __DIR__.'/config/dbpanel.php', 'dbpanel'
        );
        $this->publishes([
            __DIR__.'/config/dbpanel.php' => config_path('dbpanel.php')
        ], 'config');
    }

    public function register(){

    }
}
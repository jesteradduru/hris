<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if(!Config::get('app.debug')){
            URL::forceRootUrl(Config::get('app.url'));

            Paginator::currentPathResolver(function () {
                // generate a fully qualified URL based on the original request path
                return url(request()->path());
            });
        }
       
    }
}

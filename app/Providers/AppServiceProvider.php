<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


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
        Paginator::useBootstrap();
        //
        try {
            /** set time zone */
//            Config::set('app.timezone', $generalSetting->time_zone);


            /** Share variable at all view */
            View::composer('*', function($view) {
                $generalSetting = GeneralSetting::first();
                $logoSetting = LogoSetting::first();
                $view->with(['settings' => $generalSetting, 'logoSetting' => $logoSetting]);
            });
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }
}

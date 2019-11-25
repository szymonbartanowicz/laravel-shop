<?php

namespace App\Providers;

 use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Web\OrderController;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['nav', 'cart'], function($view) {
           $view->with('totalItems', OrderController::getTotalItems());
        });
    }
}

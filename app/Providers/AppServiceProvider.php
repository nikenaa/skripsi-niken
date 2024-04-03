<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // carbon indonesia
        \Carbon\Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.utf8');
        setlocale(LC_ALL, 'IND');
    }
}

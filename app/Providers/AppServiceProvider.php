<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 追加
use Illuminate\Support\Facades\Schema;

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
        //追加
        Schema::defaultStringLength(191);
    }
}

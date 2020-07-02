<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Articles;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //dd("Alo do Paulo");
            
        $this->app->bind(
            Articles\ArticlesRepository::class,
            Articles\EloquentRepository::class
        );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

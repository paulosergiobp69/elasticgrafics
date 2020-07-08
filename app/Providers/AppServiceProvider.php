<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Articles;
use App\Fipe_modelo;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Articles\ArticlesRepository::class, function ($app) {
            // This is useful in case we want to turn-off our
            // search cluster or when deploying the search
            // to a live, running application at first.
            if (! config('services.search.enabled')) {
                return new Articles\EloquentRepository();
            }
            
            return new Articles\ElasticsearchRepository(
                $app->make(Client::class)
            );
        });

        $this->app->bind(Fipe_modelo\FipemodeloRepository::class, function ($app) {
            // This is useful in case we want to turn-off our
            // search cluster or when deploying the search
            // to a live, running application at first.
            if (! config('services.search.enabled')) {
                return new Fipe_modelo\FipemodeloEloquent();
            }

            
            return new Fipe_modelo\ElasticsearchRepository(
                $app->make(Client::class)
            );
        });
        


        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
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

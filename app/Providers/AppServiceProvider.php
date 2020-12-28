<?php

namespace App\Providers;

use App\Services\Articles\Repositories\ElasticsearchSearchSearchArticleRepository;
use App\Services\Articles\Repositories\SearchArticleRepository;
use App\Services\Articles\Repositories\EloquentSearchArticleRepository;
use Elasticsearch\Client as ElasticsearchClient;
use Elasticsearch\ClientBuilder;
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
        $this->app->bind(SearchArticleRepository::class, ElasticsearchSearchSearchArticleRepository::class);
        $this->bindSearchClient();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    private function bindSearchClient()
    {
        $this->app->bind(ElasticsearchClient::class, function () {
            return ClientBuilder::create()
                ->setHosts(config('services.elasticsearch.hosts'))
                ->build();
        });
    }
}

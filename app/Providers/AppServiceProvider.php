<?php

namespace App\Providers;

use App\Contracts;
use App\Services;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Contracts\BBCNewsServiceInterface::class, Services\BBCNewsService::class);
        $this->app->bind(Contracts\HackerNewsServiceInterface::class, Services\HackerNewsService::class);
        $this->app->bind(Contracts\NewsScraperServiceInterface::class, Services\NewsScraperService::class);
        $this->app->bind(Contracts\SlashDotCrawlerServiceInterface::class, Services\SlashDotCrawlerService::class);
    }
}

<?php

namespace App\Providers;

use App\Repositories\JobRepository;
use App\Repositories\JobRepositoryInterface;
use App\Repositories\PolygonRepository;
use App\Repositories\PolygonRepositoryInterface;
use App\Services\NominatimApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PolygonRepositoryInterface::class, PolygonRepository::class);
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
        $this->app->singleton(NominatimApiService::class, NominatimApiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

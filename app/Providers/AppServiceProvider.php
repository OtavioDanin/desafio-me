<?php

namespace App\Providers;

use App\Repositories\LogApiGatewayRepository;
use App\Repositories\LogApiGatewayRepositoryInterface;
use App\Services\LogsApiGatewayFile;
use App\Services\LogsApiGatewayInterface;
use App\Services\LogsApiGatewayValidation;
use App\Services\LogsApiGatewayValidationInterface;
use App\Services\ProcessGatewayLogsService;
use App\Services\ProcessGatewayLogsServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogsApiGatewayInterface::class, LogsApiGatewayFile::class);
        $this->app->bind(LogsApiGatewayValidationInterface::class, LogsApiGatewayValidation::class);
        $this->app->bind(LogApiGatewayRepositoryInterface::class, LogApiGatewayRepository::class);
        $this->app->bind(ProcessGatewayLogsServiceInterface::class, ProcessGatewayLogsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

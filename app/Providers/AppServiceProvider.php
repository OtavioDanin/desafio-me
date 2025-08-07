<?php

namespace App\Providers;

use App\Repositories\LogApiGatewayRepository;
use App\Repositories\LogApiGatewayRepositoryInterface;
use App\Repositories\ReportApiGatewayRepository;
use App\Repositories\ReportApiGatewayRepositoryInterface;
use App\Services\LogsApiGatewayFileService;
use App\Services\LogsApiGatewayServiceInterface;
use App\Services\LogsApiGatewayServiceValidation;
use App\Services\LogsApiGatewayServiceValidationInterface;
use App\Services\ProcessGatewayLogsService;
use App\Services\ProcessGatewayLogsServiceInterface;
use App\Services\ReportCSVApiGatewayService;
use App\Services\ReportApiGatewayServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogsApiGatewayServiceInterface::class, LogsApiGatewayFileService::class);
        $this->app->bind(LogsApiGatewayServiceValidationInterface::class, LogsApiGatewayServiceValidation::class);
        $this->app->bind(LogApiGatewayRepositoryInterface::class, LogApiGatewayRepository::class);
        $this->app->bind(ProcessGatewayLogsServiceInterface::class, ProcessGatewayLogsService::class);


        $this->app->bind(ReportApiGatewayRepositoryInterface::class, ReportApiGatewayRepository::class);
        $this->app->bind(ReportApiGatewayServiceInterface::class, ReportCSVApiGatewayService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

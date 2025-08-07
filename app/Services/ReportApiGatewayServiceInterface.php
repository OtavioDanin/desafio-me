<?php

declare(strict_types=1);

namespace App\Services;

interface ReportApiGatewayServiceInterface
{
    public function getRequestByConsumer();
    public function getRequestByService();
    public function getAverageLatenciesByService();
}

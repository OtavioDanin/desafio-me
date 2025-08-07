<?php

declare(strict_types=1);

namespace App\Repositories;

interface ReportApiGatewayRepositoryInterface
{
    public function getRequestByConsumer();
    public function getRequestByService();
    public function getAverageLatenciesByService();
}

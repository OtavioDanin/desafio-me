<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\LogRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ReportApiGatewayRepository implements ReportApiGatewayRepositoryInterface
{
    public function __construct(protected LogRequest $logRequest) {}

    public function getRequestByConsumer(): Collection
    {
        return $this->logRequest->select("consumer_id", DB::raw('count(consumer_id) as total'))
            ->groupBy('consumer_id')
            ->orderBy('total', 'DESC')
            ->get();
    }

    public function getRequestByService(): Collection
    {
        return $this->logRequest->select("service_id", "service_name", DB::raw('count(service_id) as total'))
            ->groupBy('service_id', 'service_name')
            ->orderBy('total', 'DESC')
            ->get();
    }

    public function getAverageLatenciesByService(): Collection
    {
        return $this->logRequest->select(
            "service_id",
            "service_name",
            DB::raw('ROUND(AVG(proxy_latency), 2) as avg_proxy'),
            DB::raw('ROUND(AVG(gateway_latency), 2) as avg_gateway'),
            DB::raw('ROUND(AVG(request_latency), 2) as avg_request')
        )
            ->groupBy('service_id', 'service_name')
            ->get();
    }
}

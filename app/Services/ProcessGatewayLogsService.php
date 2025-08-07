<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ProcessGatewayLogsException;
use App\Repositories\LogApiGatewayRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProcessGatewayLogsService implements ProcessGatewayLogsServiceInterface
{
    private CONST int DATA_BATCH_LIMIT = 100;

    public function __construct(
        protected LogApiGatewayRepositoryInterface $logRequestRepository,
        protected LogsApiGatewayServiceInterface $log,
    ) {}

    public function save($dataLog): void
    {
        if(empty($dataLog)){
            throw new ProcessGatewayLogsException('Dados vazios para inserção.');
        }
        DB::transaction(function () use (&$dataLog) {
            $dataBatch = [];
            foreach ($dataLog as $data) {
                $dataBatch[] = [
                    'consumer_id' => $data['authenticated_entity']['consumer_id']['uuid'],
                    'service_id' => $data['service']['id'],
                    'service_name' => $data['service']['name'],
                    'route_host' => $data['route']['hosts'],
                    'client_ip' => $data['client_ip'],
                    'request_method' => $data['request']['method'],
                    'request_url' => $data['request']['url'],
                    'response_status' => $data['response']['status'],
                    'proxy_latency' => $data['latencies']['proxy'],
                    'gateway_latency' => $data['latencies']['gateway'],
                    'request_latency' => $data['latencies']['request'],
                    'started_at' => date('Y-m-d H:i:s', $data['started_at']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                if (count($dataBatch) >= self::DATA_BATCH_LIMIT) {
                    $this->logRequestRepository->persist($dataBatch);
                    $dataBatch = [];
                }
            }
            if (!empty($dataBatch)) {
                $this->logRequestRepository->persist($dataBatch);
            }
        });
    }
}

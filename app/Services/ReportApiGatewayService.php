<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ReportLogsException;
use App\Repositories\ReportApiGatewayRepositoryInterface;

class ReportApiGatewayService implements ReportApiGatewayServiceInterface
{
    public function __construct(protected ReportApiGatewayRepositoryInterface $reportApiGatewayRepository) {}

    private function generateFilePath($nameFile)
    {
        $timestamp = now()->format('Ymd_Hisvu');
        $filename = $nameFile . $timestamp . ".csv";
        if(!is_dir(config('app.file_path_report'))) {
            throw new ReportLogsException('Diertorio não encontrado para geração do Relatório.');
        }
        $filePath = config('app.file_path_report') . '/' . $filename;
        return fopen($filePath, 'w');
    }

    public function getRequestByConsumer(): void
    {
        $file = $this->generateFilePath('requests_by_consumer_');
        fputcsv($file, ['Consumer ID', 'Total Requests']);

        $dataConsumer = $this->reportApiGatewayRepository->getRequestByConsumer()->toArray();
        foreach ($dataConsumer as $data) {
            fputcsv($file, [$data['consumer_id'], $data['total']]);
        }
        fclose($file);
    }

    public function getRequestByService(): void
    {
        $file = $this->generateFilePath('requests_by_service_');
        fputcsv($file, ['Service ID', 'Service Name', 'Total Requests']);
        $dataService = $this->reportApiGatewayRepository->getRequestByService()->toArray();
        foreach ($dataService as $data) {
            fputcsv($file, [$data['service_id'], $data['service_name'], $data['total']]);
        }
        fclose($file);
    }

    public function getAverageLatenciesByService(): void
    {
        $file = $this->generateFilePath('average_by_service_');
        fputcsv($file, [
            'Service ID',
            'Service Name',
            'Avg Proxy Latency (ms)',
            'Avg Gateway Latency (ms)',
            'Avg Request Latency (ms)'
        ]);

        $dataAverage = $this->reportApiGatewayRepository->getAverageLatenciesByService()->toArray();
        foreach ($dataAverage as $data) {
            fputcsv($file, [$data['service_id'], $data['service_name'], $data['avg_proxy'], $data['avg_gateway'], $data['avg_request']]);
        }
        fclose($file);
    }
}

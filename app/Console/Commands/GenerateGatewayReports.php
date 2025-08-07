<?php

namespace App\Console\Commands;

use App\Exceptions\ReportLogsException;
use App\Services\ReportApiGatewayServiceInterface;
use Illuminate\Console\Command;
use Throwable;

class GenerateGatewayReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-gateway-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Generate CSV reports';

    public function __construct(protected ReportApiGatewayServiceInterface $reportApiGatewayService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->generateRequestsByConsumerReport();
        $this->generateRequestsByServiceReport();
        $this->generateAverageLatenciesByServiceReport();
    }

    protected function generateRequestsByConsumerReport()
    {
        $this->info("Gerando relatorio de Requisições por Consumidor...");
        try {
            $this->reportApiGatewayService->getRequestByConsumer();
            $this->info("Relatório de Requisições por Consumidor foi gerado com sucesso.");
        } catch (ReportLogsException $rLEx) {
            $this->warn($rLEx->getMessage());
        } catch (Throwable $thEx) {
            $this->error('Falha na geração do relatório por Consumidor.' . $thEx->getMessage());
        }
    }

    protected function generateRequestsByServiceReport()
    {
        $this->info("Gerando relatorio de Requisições por Serviço...");
        try {
            $this->reportApiGatewayService->getRequestByService();
            $this->info("Relatório de Requisições por Serviço foi gerado com sucesso.");
        } catch (ReportLogsException $rLEx) {
            $this->warn($rLEx->getMessage());
        } catch (Throwable $thEx) {
            $this->error('Falha na geração do relatório por serviço.' . $thEx->getMessage());
        }
    }

    protected function generateAverageLatenciesByServiceReport()
    {
        $this->info("Gerando relatorio de Tempo médio de request, proxy e gateway por serviço...");
        try {
            $this->reportApiGatewayService->getAverageLatenciesByService();
            $this->info("Relatório de Rrelatorio de Tempo médio por request foi gerado com sucesso.");
        } catch (ReportLogsException $rLEx) {
            $this->warn($rLEx->getMessage());
        } catch (Throwable $thEx) {
            $this->error('Falha na geração do relatório por Tempo médio de request.' . $thEx->getMessage());
        }
    }
}

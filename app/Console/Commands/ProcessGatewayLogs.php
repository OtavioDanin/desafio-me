<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Exceptions\ProcessGatewayLogsException;
use App\Services\LogsApiGatewayServiceInterface;
use App\Services\LogsApiGatewayServiceValidationInterface;
use App\Services\ProcessGatewayLogsServiceInterface;
use Illuminate\Console\Command;
use Throwable;

class ProcessGatewayLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-gateway-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command para processar o arquivo de log do API Gateway e salvar no banco de dados.';

    public function __construct(
        protected LogsApiGatewayServiceInterface $log,
        protected LogsApiGatewayServiceValidationInterface $validationLog,
        protected ProcessGatewayLogsServiceInterface $processGatewayLogsService,

    ) {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $this->validationLog->validate();
            $this->info("Processando arquivo de log da API gateway...");
            $this->processGatewayLogsService->save($this->log->getLog());
            $this->info("Processamento do log concluído!!") . PHP_EOL;
        } catch (ProcessGatewayLogsException $pGLEx) {
            $this->error($pGLEx->getMessage());
        } catch (Throwable $th) {
            $this->error("Fatal error in system." . $th->getMessage());
        }
    }
}

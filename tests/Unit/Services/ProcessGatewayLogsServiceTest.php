<?php

namespace Tests\Unit\Services;

use App\Exceptions\ProcessGatewayLogsException;
use App\Repositories\LogApiGatewayRepositoryInterface;
use App\Services\LogsApiGatewayServiceInterface;
use App\Services\ProcessGatewayLogsService;
use Illuminate\Support\Facades\DB;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ProcessGatewayLogsServiceTest extends TestCase
{
    private LogApiGatewayRepositoryInterface|MockInterface $logRequestRepositoryMock;
    private LogsApiGatewayServiceInterface|MockInterface $logServiceMock;
    private ProcessGatewayLogsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logRequestRepositoryMock = Mockery::mock(LogApiGatewayRepositoryInterface::class);
        $this->logServiceMock = Mockery::mock(LogsApiGatewayServiceInterface::class);

        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            $callback();
        });

        $this->service = new ProcessGatewayLogsService(
            $this->logRequestRepositoryMock,
            $this->logServiceMock
        );
    }

    public function test_save_should_throw_exception_when_data_is_empty(): void
    {
        $this->expectException(ProcessGatewayLogsException::class);
        $this->expectExceptionMessage('Dados vazios para inserção.');

        $this->service->save([]);
    }

    public function save_should_persist_a_single_batch_correctly(): void
    {
        $dataLog = $this->generateFakeLogData(10);

        $this->logRequestRepositoryMock
            ->shouldReceive('persist')
            ->once();

        $this->service->save($dataLog);
    }

    private function generateFakeLogData(int $count = 1): array
    {
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'authenticated_entity' => ['consumer_id' => ['uuid' => 'uuid-' . $i]],
                'service' => ['id' => 'service-id-' . $i, 'name' => 'service-name-' . $i],
                'route' => ['hosts' => ['host.com']],
                'client_ip' => '127.0.0.1',
                'request' => ['method' => 'GET', 'url' => 'http://test-tra-tra-tra.com'],
                'response' => ['status' => 200],
                'latencies' => ['proxy' => 10, 'gateway' => 5, 'request' => 15],
                'started_at' => time(),
            ];
        }
        return $data;
    }
}

<?php

namespace Tests\Unit\Repositories;

use App\Models\LogRequest;
use App\Repositories\ReportApiGatewayRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ReportApiGatewayRepositoryTest extends TestCase
{
    private LogRequest|MockInterface $logRequestMock;
    private Builder|MockInterface $builderMock;
    private ReportApiGatewayRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logRequestMock = Mockery::mock(LogRequest::class);
        $this->builderMock = Mockery::mock(Builder::class);
        $this->repository = new ReportApiGatewayRepository($this->logRequestMock);

        DB::shouldReceive('raw')->andReturnUsing(fn($str) => $str);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_getRequestByConsumer_should_build_correct_query(): void
    {
        $this->logRequestMock->shouldReceive('select')->once()->with("consumer_id", 'count(consumer_id) as total')->andReturn($this->builderMock);
        $this->builderMock->shouldReceive('groupBy')->once()->with('consumer_id')->andReturnSelf();
        $this->builderMock->shouldReceive('orderBy')->once()->with('total', 'DESC')->andReturnSelf();
        $this->builderMock->shouldReceive('get')->once()->andReturn(new Collection());

        $result = $this->repository->getRequestByConsumer();
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function test_getRequestByService_should_build_correct_query(): void
    {
        $this->logRequestMock->shouldReceive('select')->once()->with("service_id", "service_name", 'count(service_id) as total')->andReturn($this->builderMock);
        $this->builderMock->shouldReceive('groupBy')->once()->with('service_id', 'service_name')->andReturnSelf();
        $this->builderMock->shouldReceive('orderBy')->once()->with('total', 'DESC')->andReturnSelf();
        $this->builderMock->shouldReceive('get')->once()->andReturn(new Collection());

        $result = $this->repository->getRequestByService();
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function test_getAverageLatenciesByService_should_build_correct_query(): void
    {
        $this->logRequestMock->shouldReceive('select')->once()->with(
            "service_id",
            "service_name",
            'ROUND(AVG(proxy_latency), 2) as avg_proxy',
            'ROUND(AVG(gateway_latency), 2) as avg_gateway',
            'ROUND(AVG(request_latency), 2) as avg_request'
        )->andReturn($this->builderMock);
        $this->builderMock->shouldReceive('groupBy')->once()->with('service_id', 'service_name')->andReturnSelf();
        $this->builderMock->shouldReceive('get')->once()->andReturn(new Collection());

        $result = $this->repository->getAverageLatenciesByService();
        $this->assertInstanceOf(Collection::class, $result);
    }
}

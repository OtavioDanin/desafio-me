<?php

namespace Tests\Unit\Repositories;

use App\Models\LogRequest;
use App\Repositories\LogApiGatewayRepository;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class LogApiGatewayRepositoryTest extends TestCase
{
    private LogRequest|MockInterface $logRequestMock;
    private LogApiGatewayRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logRequestMock = Mockery::mock(LogRequest::class);
        $this->repository = new LogApiGatewayRepository($this->logRequestMock);
    }

    public function test_persist_should_call_insert_on_model_and_return_true(): void
    {
        $dataToPersist = [
            [
                "consumer_id" => "72b34d31-4c14-3bae-9cc6-516a0939c9d6",
                "service_id" => "c3e86413-648a-3552-90c3-b13491ee07d6",
                "service_name" => "ritchie",
                "route_host" => "miller.com",
                "client_ip" => "75.241.168.121",
                "request_method" => "GET",
                "request_url" => "http://yost.com",
                "response_status" => 500,
                "proxy_latency" => 1836,
                "gateway_latency" => 8,
                "request_latency" => 1058,
                "started_at" => "2019-08-24 15:26:27",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "consumer_id" => "72b34d31-4c14-3bae-9cc6-516a0939c9d6",
                "service_id" => "c3e86413-648a-3552-90c3-b13491ee07d6",
                "service_name" => "ritchie",
                "route_host" => "miller.com",
                "client_ip" => "75.241.168.121",
                "request_method" => "GET",
                "request_url" => "http://yost.com",
                "response_status" => 500,
                "proxy_latency" => 1836,
                "gateway_latency" => 8,
                "request_latency" => 1058,
                "started_at" => "2019-08-24 15:26:27",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $this->logRequestMock
            ->shouldReceive('insert')
            ->once()
            ->with($dataToPersist)
            ->andReturn(true);

        $result = $this->repository->persist($dataToPersist);
        $this->assertTrue($result);
    }

    public function test_persist_should_call_insert_on_model_and_return_false(): void
    {
        $dataToPersist = [];

        $this->logRequestMock
            ->shouldReceive('insert')
            ->once()
            ->with($dataToPersist)
            ->andReturn(false);

        $result = $this->repository->persist($dataToPersist);
        $this->assertFalse($result);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}

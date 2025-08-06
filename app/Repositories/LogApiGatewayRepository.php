<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\LogRequest;

class LogApiGatewayRepository implements LogApiGatewayRepositoryInterface
{
    public function __construct(protected LogRequest $logRequest) {}

    public function persist(array $data): bool
    {
        return $this->logRequest->insert($data);
    }
}

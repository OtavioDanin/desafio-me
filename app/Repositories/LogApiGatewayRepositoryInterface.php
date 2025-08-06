<?php

declare(strict_types=1);

namespace App\Repositories;

interface LogApiGatewayRepositoryInterface
{
    public function persist(array $data);
}
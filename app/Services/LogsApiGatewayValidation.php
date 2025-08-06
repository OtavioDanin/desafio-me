<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ProcessGatewayLogsException;

class LogsApiGatewayValidation implements LogsApiGatewayValidationInterface
{
    public function validate(): void
    {
        $filePath = config('app.file_path');
        if (!file_exists($filePath)) {
            sleep(1);
            throw new ProcessGatewayLogsException('File not found.' . $filePath);
        }
    }
}

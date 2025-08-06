<?php

declare(strict_types=1);

namespace App\Services;

use Generator;

class LogsApiGatewayFile implements LogsApiGatewayInterface
{
    public function getLog(): Generator
    {
        $handle = fopen(config('app.file_path'), 'r');
        while (!feof($handle)) {
            $line = fgets($handle);
            if ($line !== false) {
                yield json_decode($line, true);
            }
        }
        fclose($handle);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRequest extends Model
{
    use HasFactory;

    protected $table = 'log_requests';

    protected $fillable = [
        'consumer_id',
        'service_id',
        'service_name',
        'route_host',
        'client_ip',
        'request_method',
        'request_url',
        'response_status',
        'proxy_latency',
        'gateway_latency',
        'request_latency',
        'started_at'
    ];
}

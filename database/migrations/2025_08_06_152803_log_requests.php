<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('consumer_id');
            $table->uuid('service_id');
            $table->string('service_name');
            $table->string('route_host');
            $table->string('client_ip');
            $table->string('request_method');
            $table->string('request_url');
            $table->integer('response_status');
            $table->integer('proxy_latency');
            $table->integer('gateway_latency');
            $table->integer('request_latency');
            $table->timestamp('started_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_requests');
    }
};

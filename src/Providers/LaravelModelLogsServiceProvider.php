<?php

namespace Asif\LaravelModelLogs\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelModelLogsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}

<?php

namespace algeriany\wallet;

use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/models' => app_path('Models'),
        ], 'models');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'migrations');
    }

    public function register() {}
}

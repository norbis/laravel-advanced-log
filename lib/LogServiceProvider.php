<?php

namespace Norbis\AdvancedLog;

use Illuminate\Support\ServiceProvider;
use Norbis\AdvancedLog\Log\LogManager;

/**
 * Class LogServiceProvider
 * @package Norbis\AdvancedLog
 */
class LogServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('log', function ($app) {
            return new LogManager($app);
        });
    }
}

<?php

namespace NotificationChannels\Clickatell;

use Clickatell\Rest;
use Illuminate\Support\ServiceProvider;

class ClickatellServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->when(ClickatellChannel::class)
            ->needs(ClickatellClient::class)
            ->give(function () {
                $config = config('services.clickatell');

                return new ClickatellClient(
                    new Rest(
                        $config['api_key']
                    )
                );
            });
    }
}

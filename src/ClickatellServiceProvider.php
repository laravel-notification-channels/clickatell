<?php

namespace NotificationChannels\Clickatell;

use Clickatell\Api\ClickatellHttp;
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
                    new ClickatellHttp(
                        $config['user'],
                        $config['pass'],
                        $config['api_id']
                    )
                );
            });
    }
}

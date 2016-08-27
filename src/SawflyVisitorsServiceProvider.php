<?php

namespace Sawfly\Visitors;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;

class SawflyVisitorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        parent::boot($events);
        $events->listen('Sawfly\Visitors\Events\ConnectionEvent', 'Sawfly\Visitors\Listeners\ConnectionEventListener');
        $this->publishes([__DIR__.'/migrations' =>database_path().'/migrations']);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}

<?php namespace Symposium\Providers;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @param  \Illuminate\Bus\Dispatcher  $dispatcher
     * @return void
     */
    public function boot(Dispatcher $dispatcher)
    {
        $dispatcher->mapUsing(function ($command) {

            return Dispatcher::simpleMapping(
                $command,
                'Symposium\Commands',
                'Symposium\Handlers\Commands'
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

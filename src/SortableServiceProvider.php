<?php

namespace Kenarkose\Sortable;


use Illuminate\Support\ServiceProvider;

class SortableServiceProvider extends ServiceProvider {

    const version = '1.1.4';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sortable.supporter'];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSupporter();
    }

    /**
     * Registers the supporter
     */
    protected function registerSupporter()
    {
        $this->app->singleton(
            'sortable.supporter',
            'Kenarkose\Sortable\Supporter'
        );
    }

}
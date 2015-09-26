<?php

namespace Kenarkose\Sortable;


use Illuminate\Support\ServiceProvider;

class SortableServiceProvider extends ServiceProvider {

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

    /**
     * Boots the provider
     */
    public function boot()
    {
        require __DIR__ . '/helpers.php';
    }

}
<?php

namespace demi\gearman\laravel5;

/**
 * Gearman aueue service provider
 */
class GearmanServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->singleton('gearman', function ($app) {
            $component = new \demi\gearman\GearmanQueue(
                config('gearman.host', '127.0.0.1'),
                config('gearman.port', 4730),
                config('gearman.servers', [])
            );
            $component->beforeJobCallback = config('gearman.beforeJobCallback');
            $component->afterJobCallback = config('gearman.afterJobCallback');

            return $component;
        });

        $this->app['command.gearman'] = $this->app->singleton(
            function ($app) {
                return new \demi\gearman\laravel5\Console\SupervisorCommand();
            }
        );
        $this->commands('command.gearman');
    }

    public function boot()
    {
        $this->publishes(array(
            __DIR__ . '/config/gearman.php' => config_path('gearman.php'),
        ), 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('gearman', 'command.gearman');
    }
}
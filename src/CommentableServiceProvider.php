<?php

namespace LongZIP\Commentable;

use Illuminate\Support\ServiceProvider;

class CommentableServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'longzip');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'longzip');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->publishes([
            __DIR__.'/../database/migrations/create_comments_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_comments_table.php'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/commentable.php' => config_path('commentable.php'),
        ], 'config');
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/commentable.php', 'commentable');

        // Register the service the package provides.
        $this->app->singleton('commentable', function ($app) {
            return new Commentable;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['commentable'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/commentable.php' => config_path('commentable.php'),
        ], 'commentable.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/longzip'),
        ], 'commentable.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/longzip'),
        ], 'commentable.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/longzip'),
        ], 'commentable.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

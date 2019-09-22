<?php

declare(strict_types=1);

/**
 * Laravel Commentable Package by Ali Bayat.
 */

namespace AliBayat\LaravelCommentable;

use Illuminate\Support\ServiceProvider;

class CommentableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../migrations/create_comments_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_comments_table.php'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/laravel-commentable.php' => config_path('laravel-commentable.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-commentable.php', 'laravel-commentable');
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repository\Interfaces\UserRepositoryInterface', 'App\Repository\UserRepository');
        $this->app->bind('App\Repository\Interfaces\PostRepositoryInterface', 'App\Repository\PostRepository');
        $this->app->bind('App\Repository\Interfaces\CommentRepositoryInterface', 'App\Repository\CommentRepository');
    }
}

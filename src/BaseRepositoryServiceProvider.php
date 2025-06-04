<?php

namespace DuongNX\BaseRepository;

use Illuminate\Support\ServiceProvider;

class BaseRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(
            BaseRepositoryInterface::class,
            BaseRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}

<?php

namespace App\Providers;
use App\Interfaces\ProjectsRepositoryInterface;
use App\Repositories\ProjectsRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProjectsRepositoryInterface::class, ProjectsRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace Sqits\UserStamps;

use Illuminate\Support\ServiceProvider;
use Sqits\UserStamps\Database\Schema\Macros\UserStampsMacro;

class UserStampsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/userstamps.php' => config_path('userstamps.php'),
        ], 'config');

        $userStampsMacro = new UserStampsMacro();
        $userStampsMacro->register();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/userstamps.php', 'userstamps'
        );
    }
}

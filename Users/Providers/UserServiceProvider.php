<?php

namespace PhpSoft\Users\Providers;

use Illuminate\Support\ServiceProvider;
use PhpSoft\Users\Commands\MigrationCommand;

class UserServiceProvider extends ServiceProvider
{
  /**
   * Boot the service provider.
   */
  public function boot()
  {
    // Set views path
    $this->loadViewsFrom(__DIR__ . '/../resources/views', 'phpsoft.users');

    // Publish views
    $this->publishes([
      __DIR__ . '/../resources/views' => base_path('resources/views/vendor/phpsoft.users'),
    ]);

    // Publish config files
    $this->publishes([
      __DIR__ . '/../config/jwt.php'     => config_path('jwt.php'),
      __DIR__ . '/../config/entrust.php' => config_path('entrust.php'),
    ]);

    // Register commands
    $this->commands('phpsoft.users.command.migration');

    // Publish migration files
    $this->publishes([
      __DIR__ . '/../Commands/migrations' => base_path('database/migrations'),
    ], 'migrations');
  }

  /**
   * Register bindings in the container.
   *
   * @return void
   */
  public function register()
  {
    $this->registerCommands();
  }

  /**
   * Register the artisan commands.
   *
   * @return void
   */
  private function registerCommands()
  {
    $this->app->bindShared('phpsoft.users.command.migration', function () {
      return new MigrationCommand();
    });
  }
}

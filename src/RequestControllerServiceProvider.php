<?php

namespace Lorisleiva\RequestController;

use Illuminate\Support\ServiceProvider;
use Lorisleiva\RequestController\Commands\RequestControllerCommand;

class RequestControllerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/request-controller.php' => config_path('request-controller.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/request-controller'),
            ], 'views');

            $migrationFileName = 'create_request_controller_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                RequestControllerCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'request-controller');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/request-controller.php', 'request-controller');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}

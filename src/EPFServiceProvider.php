<?php

namespace Appwapp\EPF;

use Appwapp\EPF\Exceptions\AppleEpfLaravelException;
use Appwapp\EPF\Exceptions\MigrationNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class EPFServiceProvider extends ServiceProvider    
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Only load commands if included
            if (config('apple-epf.include_artisan_cmd')) {
                $this->commands([
                    Commands\EPFDownloader::class,
                    Commands\EPFExtractor::class,
                    Commands\EPFImportToDatabase::class,
                ]);
            }

            // Publish config and migrations
            $this->publishesConfig();
            $this->publishesMigrations();
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/apple-epf.php', 'apple-epf');
    }

    /**
     * Laod configuration to publish.
     *
     * @return void
     */
    protected function publishesConfig (): void
    {
        // Publishes the configuration
        $this->publishes([
            __DIR__ . '/../config/apple-epf.php' => config_path('apple-epf.php'),
        ], 'apple-epf-config');
    }

    /**
     * Load migrations dynamically with the configuration.
     *
     * @return void
     */
    protected function publishesMigrations (): void
    {
        // Get the date
        $date = Carbon::now();

        // Generates the migrations to publish depending on config
        $migrations = [];
        try {
            foreach (config('apple-epf.included_models') as $model) {
                if (! class_exists($model)) {
                    throw new ModelNotFoundException("Model '{$model}' does not exists. Make sure the 'apple-epf.included_models' configuration is up to date.");
                }

                // Generate migration path from model name
                $table           = $model::getTableName();
                $migrationSource = sprintf('create_apple_epf_%s_table.php', $table);
                $pathSource      = sprintf('%s/../database/migrations/%s', __DIR__, $migrationSource);
                if (! file_exists($pathSource)) {
                    throw new MigrationNotFoundException("Migration '$migrationSource' does not exists. Make sure the 'apple-epf.included_models' configuration is up to date.");
                }

                // Build the migrations array
                $migrations[$pathSource] = database_path(sprintf('migrations/%s_create_apple_epf_%s_table.php', $date->format('Y_m_d_His'), $table));
            }
        } catch (AppleEpfLaravelException $exception) {
            // Log the error instead of throwing it, to not interrupt every artisan command
            Log::error($exception->getMessage());
        }

        // Publishes the migrations
        $this->publishes($migrations, 'apple-epf-migrations');
    }
}

<?php

namespace JeffersonGoncalves\Testimonial\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JeffersonGoncalves\Testimonial\TestimonialServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'JeffersonGoncalves\\Testimonial\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            TestimonialServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $configPath = __DIR__.'/../config/testimonial.php';
        if (file_exists($configPath)) {
            $app['config']->set('testimonial', require $configPath);
        }
    }

    protected function defineDatabaseMigrations(): void
    {
        $stubsPath = __DIR__.'/../database/migrations';
        $tempPath = sys_get_temp_dir().'/laravel-testimonial-migrations';

        if (! is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        foreach (glob($stubsPath.'/*.php.stub') as $stub) {
            $filename = basename(str_replace('.php.stub', '.php', $stub));
            $target = $tempPath.'/'.$filename;

            copy($stub, $target);
        }

        $this->loadMigrationsFrom($tempPath);
    }
}

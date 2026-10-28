<?php

namespace JeffersonGoncalves\Testimonial\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JeffersonGoncalves\PestPluginDatabaseMigrations\LoadsPackageMigrations;
use JeffersonGoncalves\Testimonial\TestimonialServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    use LoadsPackageMigrations;
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
        $app['config']->set('database.connections.testing', $this->testing_connection());

        $configPath = __DIR__.'/../config/testimonial.php';
        if (file_exists($configPath)) {
            $app['config']->set('testimonial', require $configPath);
        }
    }

    /**
     * Defaults to an in-memory SQLite connection for local development; CI
     * (tests.yml) sets TESTIMONIAL_TEST_DB_* to run the same suite against
     * real MySQL and PostgreSQL instances too. Deliberately not the plain
     * DB_* names: Orchestra Testbench itself sets DB_CONNECTION=testing by
     * convention, which would collide with (and always win over) a driver
     * value read from the same variable here.
     *
     * @return array<string, mixed>
     */
    protected function testing_connection(): array
    {
        $driver = env('TESTIMONIAL_TEST_DB_DRIVER', 'sqlite');

        if ($driver === 'sqlite') {
            return ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''];
        }

        return [
            'driver' => $driver,
            'host' => env('TESTIMONIAL_TEST_DB_HOST', '127.0.0.1'),
            'port' => env('TESTIMONIAL_TEST_DB_PORT'),
            'database' => env('TESTIMONIAL_TEST_DB_DATABASE', 'testing'),
            'username' => env('TESTIMONIAL_TEST_DB_USERNAME', 'root'),
            'password' => env('TESTIMONIAL_TEST_DB_PASSWORD', ''),
            'charset' => $driver === 'pgsql' ? 'utf8' : 'utf8mb4',
            'prefix' => '',
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadPackageMigrations(TestimonialServiceProvider::class);
    }
}

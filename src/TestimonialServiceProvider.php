<?php

namespace JeffersonGoncalves\Testimonial;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\Translatable\Translatable;

class TestimonialServiceProvider extends PackageServiceProvider
{
    public static string $name = 'testimonial';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasMigrations([
                'create_testimonials_table',
            ]);
    }

    public function packageBooted(): void
    {
        app(Translatable::class)->fallback(
            fallbackLocale: config('app.fallback_locale', 'en'),
            fallbackAny: true,
        );
    }
}

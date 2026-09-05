<div class="filament-hidden">

![Laravel Testimonial](https://raw.githubusercontent.com/jeffersongoncalves/laravel-testimonial/main/art/jeffersongoncalves-laravel-testimonial.png)

</div>

# Laravel Testimonial

[![Buy Me A Coffee](https://img.shields.io/badge/Buy%20Me%20A%20Coffee-support-FFDD00?style=flat-square&logo=buy-me-a-coffee&logoColor=black)](https://buymeacoffee.com/jeffersongoncalves)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-testimonial.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-testimonial)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-testimonial/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-testimonial/actions?query=workflow%3ATests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-testimonial/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-testimonial/actions?query=workflow%3A%22Fix+PHP+code+style+issues%22+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-testimonial.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-testimonial)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/laravel-testimonial.svg?style=flat-square)](LICENSE.md)

A Laravel package for managing testimonials, with translatable content powered by [spatie/laravel-translatable](https://github.com/spatie/laravel-translatable).

## Features

- **Testimonials** — Name, role, company, avatar, rating (1-5), order, and active flag
- **Translatable Content** — Testimonial content is translatable via `spatie/laravel-translatable`, with automatic fallback to the app's fallback locale
- **Ordering & Activation** — `ordered()` and `active()` query scopes
- **Configurable Table Name** — Override the `testimonials` table name via config
- **Configurable Locales** — Mirrors `app.available_locales` (or the app locale) to describe supported translation locales

## Requirements

- PHP 8.2+
- Laravel 12.x or 13.x

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-testimonial
```

Publish and run the migrations:

```bash
php artisan vendor:publish --tag="testimonial-migrations"
php artisan migrate
```

Publish the config file (optional):

```bash
php artisan vendor:publish --tag="testimonial-config"
```

## Configuration

The config file (`config/testimonial.php`) covers:

### Table Names

```php
'table_names' => [
    'testimonials' => 'testimonials',
],
```

### Locales

```php
'locales' => config('app.available_locales')
    ? array_keys(config('app.available_locales'))
    : [config('app.locale', 'en')],
```

Reads from `app.available_locales` (an array keyed by locale code, e.g. `['en' => 'English', 'pt_BR' => 'Português']`) when present, otherwise falls back to the app's default locale. The package also configures `spatie/laravel-translatable`'s fallback behavior on boot, so a missing translation for the current locale falls back to `app.fallback_locale` (or any available locale if that is also missing).

## Usage

### Testimonials

```php
use JeffersonGoncalves\Testimonial\Models\Testimonial;

$testimonial = Testimonial::create([
    'name' => 'Jane Cooper',
    'role' => 'CEO',
    'company' => 'Acme Inc.',
    'avatar' => 'avatars/jane-cooper.jpg',
    'content' => ['en' => 'This product changed how we work.', 'pt_BR' => 'Este produto mudou a forma como trabalhamos.'],
    'rating' => 5,
    'order' => 1,
    'is_active' => true,
]);

$testimonial->content; // resolved for the current app locale, with fallback
```

Only `content` is translatable — `name`, `role`, `company`, and `avatar` are plain strings.

### Scopes

```php
Testimonial::active()->ordered()->get();
```

### Translations

Because the model uses `Spatie\Translatable\HasTranslations`, the full [spatie/laravel-translatable API](https://github.com/spatie/laravel-translatable) is available:

```php
$testimonial->getTranslation('content', 'pt_BR');
$testimonial->setTranslation('content', 'pt_BR', 'Recomendo muito!');
$testimonial->getTranslations('content'); // ['en' => '...', 'pt_BR' => '...']
$testimonial->translate('content', 'pt_BR');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

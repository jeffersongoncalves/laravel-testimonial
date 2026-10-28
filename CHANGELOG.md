# Changelog

All notable changes to this project will be documented in this file.

## 1.0.1 - 2026-10-28

Tests now load the package migrations with jeffersongoncalves/pest-plugin-database-migrations, in the order declared by the service provider, instead of copying the .php.stub files by hand. No runtime changes.

## 1.0.0 - 2026-08-30

**Full Changelog**: https://github.com/jeffersongoncalves/laravel-testimonial/commits/1.0.0

## [Unreleased]

### Added

- Initial release: `Testimonial` model with translatable content field, `active()`/`ordered()` scopes, migration, config, and tests

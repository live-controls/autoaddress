# Contributing to AutoAddress

## Project overview

AutoAddress is a Laravel package with Livewire components and PHP helpers for
postal address, ZIP code, and GeoIP lookups.

- `src/Scripts/` contains external lookup integrations.
- `src/Objects/` contains response value objects.
- `src/Http/Livewire/` contains the Livewire address component.
- `config/config.php` is published as `config/livecontrols_autoaddress.php`.
- `resources/views/` and `lang/` contain package UI resources.
- `resources/boost/guidelines/` contains Laravel Boost guidance for this package.

## Development

Install dependencies with:

```shell
composer install
```

Run the test suite with:

```shell
vendor/bin/phpunit
```

Before submitting changes:

1. Keep the public API backwards compatible unless a change is intentional.
2. Reuse existing response objects and configuration keys.
3. Use Laravel and Livewire conventions and preserve translation support.
4. Add focused tests for new behavior.
5. Update `README.md` and the Boost guideline when public usage changes.

Do not commit credentials, API tokens, GeoIP database files, or generated
dependency directories.

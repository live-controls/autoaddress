# AutoAddress

[![Release Version](https://img.shields.io/github/v/release/live-controls/autoaddress)](https://github.com/live-controls/autoaddress/releases)
[![Packagist Version](https://img.shields.io/packagist/v/live-controls/autoaddress?color=%23007500)](https://packagist.org/packages/live-controls/autoaddress)

AutoAddress provides Livewire address inputs and PHP helpers for looking up
postal addresses, ZIP codes, and IP-based location data.

## Requirements

- PHP version supported by your Laravel application
- Laravel 11 or later
- Livewire 2, 3, or 4

## Installation

```shell
composer require live-controls/autoaddress
```

The service provider is discovered automatically. Publish the package
configuration when you need to change defaults:

```shell
php artisan vendor:publish --tag=livecontrols.autoaddress.config
```

The published file is `config/livecontrols_autoaddress.php`.

## Address lookup

### CepAberto (Brazil)

```php
use LiveControls\AutoAddress\Objects\CepAbertoResponse;

$response = new CepAbertoResponse('01000-001');

if ($response->isValid()) {
    echo $response->street;
    echo $response->city;
    echo $response->state;
}
```

`CepAbertoResponse` exposes `status`, `cep`, `ibge`, `ddd`, `street`,
`complement`, `area`, `city`, `state`, `uf`, `country`, `longitude`,
`latitude`, and `altitude`.

### ViaCEP

```php
use LiveControls\AutoAddress\Scripts\ViaCep;

$address = ViaCep::fromCep('01000-001');
```

The result includes a `statusText` value of `ok`, `invalid`, or
`connection_error`.

### ZipCodebase

Set `ZIPCODEBASE_TOKEN` in `.env`, then use the response object:

```php
use LiveControls\AutoAddress\Objects\ZipCodebaseResponse;

$response = new ZipCodebaseResponse('10001', 'us');
```

The response exposes `isValid()`, `status`, and the returned `results`.

## Livewire component

Use the registered component in a Livewire view:

```blade
<livewire:livecontrols-autoaddress />
```

Set the component's `backend` to `cepaberto` (the default) or `zipcodebase`.
The component also supports custom field names, prefixes, required fields,
and loading values from an existing model.

## GeoIP lookup

GeoIP support uses a MaxMind GeoIP2 City `.mmdb` database. Configure the
database path and enable the feature in `.env`:

```dotenv
GEOIP2_ENABLED=true
GEOIP2_DATABASE_PATH=/absolute/path/to/GeoIP2-City.mmdb
```

Then resolve an IP address:

```php
use LiveControls\AutoAddress\Scripts\GeoIp;

$location = GeoIp::fromIp(request()->ip());

echo $location->city;
echo $location->state;
echo $location->country;
```

`GeoIp::fromIp()` returns a `GeoIpResponse` with `ip`, `areacode`, `city`,
`state`, and `country`. Reader and record lookups are cached by default:

```php
$record = GeoIp::getRecord('8.8.8.8', useCache: false);
$reader = GeoIp::getReader(cacheTime: 7200);
```

If GeoIP is enabled but the database cannot be found, the helper throws an
exception instead of silently returning incomplete data. An IP not found in
the database returns a response containing only the IP address.

## Translations

The package includes English (`en`), German (`de`), and Brazilian Portuguese
(`pt_BR`) translations. Publish them with:

```shell
php artisan vendor:publish --tag=livecontrols.autoaddress.localization
```

## Laravel Boost

Laravel Boost automatically discovers this package's AI guidance. In a
Laravel application, install Boost and generate its resources with:

```shell
composer require laravel/boost --dev
php artisan boost:install
```

The package guidance is stored in
`resources/boost/guidelines/core.blade.php` and is included when Boost
generates `AGENTS.md` or other agent instructions.

## License

AutoAddress is open-sourced software licensed under the [MIT license](LICENSE).

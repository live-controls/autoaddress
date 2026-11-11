## AutoAddress

AutoAddress is a Laravel package providing Livewire address inputs and PHP
helpers for postal, ZIP code, and GeoIP lookups.

### Conventions

- Use `LiveControls\AutoAddress\Objects\` response objects for structured
  lookup results.
- Use `LiveControls\AutoAddress\Scripts\ViaCep` for Brazilian ViaCEP lookups.
- Use `LiveControls\AutoAddress\Scripts\GeoIp` for MaxMind GeoIP2 City lookups.
- Read package settings from the published
  `config/livecontrols_autoaddress.php` file.
- Do not commit API tokens or `.mmdb` GeoIP databases.

### GeoIP configuration

Set `GEOIP2_ENABLED=true` and point `GEOIP2_DATABASE_PATH` at a local
GeoIP2 City database before calling `GeoIp::fromIp()`. GeoIP reader and
record lookups use Laravel's cache by default.

@verbatim
<code-snippet name="Resolve an IP address" lang="php">
use LiveControls\AutoAddress\Scripts\GeoIp;

$location = GeoIp::fromIp($ipAddress);
</code-snippet>
@endverbatim

### Livewire component

The package registers the `livecontrols-autoaddress` component. Use
`<livewire:livecontrols-autoaddress />` in Blade and select `cepaberto` or
`zipcodebase` as the backend.

# Auto Address
 ![Release Version](https://img.shields.io/github/v/release/live-controls/autoaddress)
 ![Packagist Version](https://img.shields.io/packagist/v/live-controls/autoaddress?color=%23007500)

 An Input for Addresses which would give you the informations for road, etc. based on different APIs

## Requirements
- Laravel 9+
- Livewire 2+


## Translations
- English (en)
- German (de)
- Brazilian Portuguese (pt_BR)


## Installation

1. Install AutoAddress package
```ps
composer require live-controls/autoaddress
```


### Content
TODO

## Usage
1. Add CEPABERTO_TOKEN and/or ZIPCODEBASE_TOKEN env variable
2. If you want you can publish the configuration file and change the variables there
3. Basic Usage:
```php
$cep = 01000001;
$response = new \LiveControls\AutoAddress\Objects\CepAbertoResponse($cep);
//or
$cep = "01000-001"; //Can be a string as well, the CepAberto::fromCep() method will remove everything but numbers
$response = new \LiveControls\AutoAddress\Objects\CepAbertoResponse($cep);
```
The $response object contains the following variables:
- $status => The status of the response, can also be tested with $response->isValid()
- $cep => The CEP of the address, this is identical to the $cep sent to the server
- $ibge => The IBGE of the address
- $ddd => The phone DDD of the address
- $street => The street of the address
- $complement => The complement of the address
- $area => The area of the address
- $city => The city of the address
- $state => The state of the address
- $uf => The UF of the address
- $country => The country of the address (In case of CepAberto its always Brazil)
- $longitude => The longitude of the address (Can be null!)
- $latitude => The latitude of the address (Can be null!)
- $altitude => The altitude of the address (Can be null!)
4. If environment variables dont work, try publish the configuration file, this will probably be patched in the future.

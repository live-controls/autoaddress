<?php

namespace LiveControls\AutoAddress\Objects;

class ZipCodebaseResult
{
    public readonly string $postalCode;
    public readonly string $countryCode;
    public readonly string $latitude;
    public readonly string $longitude;
    public readonly string $city;
    public readonly string $state;
    public readonly string $cityEnglish;
    public readonly string $stateEnglish;
    public readonly string $stateCode;

    public function __construct(array $resultData)
    {
        $this->postalCode = array_key_exists("postal_code", $resultData) ? $resultData["postal_code"] : null;
        $this->countryCode = array_key_exists("country_code", $resultData) ? $resultData["country_code"] : null;
        $this->latitude = array_key_exists("latitude", $resultData) ? $resultData["latitude"] : null;
        $this->longitude = array_key_exists("longitude", $resultData) ? $resultData["longitude"] : null;
        $this->city = array_key_exists("city", $resultData) ? $resultData["city"] : null;
        $this->state = array_key_exists("state", $resultData) ? $resultData["state"] : null;
        $this->cityEnglish = array_key_exists("city_en", $resultData) ? $resultData["city_en"] : null;
        $this->stateEnglish = array_key_exists("state_en", $resultData) ? $resultData["state_en"] : null;
        $this->stateCode = array_key_exists("state_code", $resultData) ? $resultData["state_code"] : null;
    }

}
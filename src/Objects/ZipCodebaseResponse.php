<?php

namespace LiveControls\AutoAddress\Objects;

use LiveControls\AutoAddress\Scripts\ZipCodebase;

class ZipCodebaseResponse
{
    public readonly string $status;
    public readonly string $country;
    public readonly array $results;

    public function __construct(string $zipCodes, string $country)
    {
        $response = ZipCodebase::fromZip($zipCodes, $country);
        $this->status = $response["statusText"];
        $this->country = $country;
        foreach($response["results"] as $result)
        {
            array_push($this->results, new ZipCodebaseResult($result));
        }
        $this->status = "ok";
    }

    public function isValid(): bool
    {
        return $this->status == "ok";
    }
}
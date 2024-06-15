<?php

namespace LiveControls\AutoAddress\Objects;

use LiveControls\AutoAddress\Scripts\ViaCep;

class ViaCepResponse
{
    public readonly string $status;
    public readonly string $cep;
    public readonly string $ibge;
    public readonly string $gia;
    public readonly string $siafi;
    public readonly string $ddd;
    public readonly string $street;
    public readonly string $complement;
    public readonly string $area;
    public readonly string $city;
    public readonly string $state;
    public readonly string $country;

    public function __construct(int|string $cep)
    {
        $response = ViaCep::fromCep($cep);
        $this->status = $response["statusText"];
        $this->cep = $cep;
        $this->complement = $response["complemento"];
        $this->ibge = $response["ibge"];
        $this->gia = $response["gia"];
        $this->siafi = $response["siafi"];
        $this->ddd = $response["ddd"];
        $this->street = $response["logradouro"];
        $this->area = $response["bairro"];
        $this->city = $response["localidade"];
        $this->state = $response["uf"];
        $this->country = "BR";
    }

    public function isValid(): bool
    {
        return $this->status == "ok";
    }
}
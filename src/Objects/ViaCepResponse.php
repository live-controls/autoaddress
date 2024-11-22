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
    public readonly string $uf;
    public readonly string $state;
    public readonly string $country;

    public function __construct(int|string $cep)
    {
        $response = ViaCep::fromCep($cep);
        $this->status = $response["statusText"];
        $this->cep = $cep;
        $this->complement = array_key_exists("complemento", $response) ? $response["complemento"] : "";
        $this->ibge = array_key_exists("ibge", $response) ? $response["ibge"] : "";
        $this->gia = array_key_exists("gia", $response) ? $response["gia"] : "";
        $this->siafi = array_key_exists("siafi", $response) ? $response["siafi"] : "";
        $this->ddd = array_key_exists("ddd", $response) ? $response["ddd"] : "";
        $this->street = array_key_exists("logradouro", $response) ? $response["logradouro"] : "";
        $this->area = array_key_exists("bairro", $response) ? $response["bairro"] : "";
        $this->city = array_key_exists("localidade", $response) ? $response["localidade"] : "";
        $this->uf = array_key_exists("uf", $response) ? $response["uf"] : "";
        $this->state = array_key_exists("state", $response) ? $response["state"] : "";
        $this->country = "BR";
    }

    public function isValid(): bool
    {
        return $this->status == "ok";
    }
}
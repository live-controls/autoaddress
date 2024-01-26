<?php

namespace LiveControls\AutoAddress\Objects;

use LiveControls\AutoAddress\Scripts\CepAberto;

class CepAbertoResponse
{
    public readonly string $status;
    public readonly string $cep;
    public readonly string $ibge;
    public readonly string $ddd;
    public readonly string $street;
    public readonly string $complement;
    public readonly string $area;
    public readonly string $city;
    public readonly string $state;
    public readonly string $country;
    public readonly string $longitude;
    public readonly string $latitude;
    public readonly string $altitude;

    public function __construct(int|string $cep)
    {
        $response = CepAberto::fromCep($cep);
        
        $this->status = $response["statusText"];
        if(array_key_exists("cidade", $response)){
            $this->ibge = array_key_exists("ibge", $response["cidade"]) ? $response["cidade"]["ibge"] : null;
            $this->ddd = array_key_exists("ddd", $response["cidade"]) ? $response["cidade"]["ddd"] : null;
            $this->city = array_key_exists("nome", $response["cidade"]) ? $response["cidade"]["nome"] : null;
        }
        $this->street = array_key_exists("logradouro", $response) ? $response["logradouro"] : null;
        $this->complement = array_key_exists("complemento", $response) ? $response["complemento"] : null;
        $this->area = array_key_exists("bairro", $response) ? $response["bairro"] : null;
        if(array_key_exists("estado", $response)){
            $this->state = array_key_exists("sigla", $response["estado"]) ? $response["estado"]["sigla"] : null;
        }
        $this->longitude = array_key_exists("longitude", $response) ? $response["longitude"] : null;
        $this->latitude = array_key_exists("latitude", $response) ? $response["latitude"] : null;
        $this->altitude = array_key_exists("altitude", $response) ? $response["altitude"] : null;
        $this->cep = $cep;
    }

    public function isValid(): bool
    {
        return $this->status == "ok";
    }
}
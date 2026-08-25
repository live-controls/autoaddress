<?php
namespace LiveControls\AutoAddress\Scripts;

use Illuminate\Support\Facades\Http;

class ViaCep
{
    public static function fromCep(int|string $cep): array
    {
        $cep = preg_replace('/[^0-9]/', '', $cep); //Remove everything but numbers
        if(strlen($cep) != 8)
        {
            return ["statusText" => "invalid"];
        }

        $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->get('https://viacep.com.br/ws/'.$cep.'/json');

        if(!$response->ok()){
            return ['statusText' => 'connection_error'];
        }

        $json = (array) $response->json();
        if(array_key_exists("erro", $json)){
            return ["statusText" => "invalid"];
        }

        return array_merge($json, ["statusText" => "ok"]);
    }
}
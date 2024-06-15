<?php
namespace LiveControls\AutoAddress\Scripts;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use LiveControls\Utils\Utils;

class ViaCep
{
    public static function fromCep(int|string $cep, string $token = null): array
    {
        $cep = preg_replace('/[^0-9]/', '', $cep); //Remove everything but numbers
        if(Utils::countNumber($cep) != 8)
        {
            return ["statusText" => "invalid"];
        }
        $client = new Client();

        try{
            $response = $client->request('GET', 'https://viacep.com.br/ws/'.$cep.'/json/ ', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);
        }catch(GuzzleException $ex)
        {
            Log::warning("Couldn\'t fetch CEP, server said: ".$ex->getMessage());
            return ["statusText" => "connection_error"];
        }catch(Exception $ex)
        {
            Log::warning("Couldn't fetch CEP due to an internal error, server said: ".$ex->getMessage());
            return ["statusText" => "internal_error"];
        }
        $json = json_decode($response->getBody(),true);
        if(array_key_exists("erro", $json)){
            return ["statusText" => "invalid"];
        }
        return array_merge($json, ["statusText" => "ok"]);
    }
}
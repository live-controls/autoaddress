<?php

namespace LiveControls\AutoAddress\Scripts;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use LiveControls\Utils\Utils;

/**
 * @deprecated 1.0.1 Host at cepaberto.com does not longer work
 */
class CepAberto
{
    public static function fromCep(int|string $cep, string $token = null): array
    {
        $cep = preg_replace('/[^0-9]/', '', $cep); //Remove everything but numbers

        if(strlen($cep) != 8)
        {
            return ["statusText" => "invalid"];
        }

        $token = config('livecontrols_autoaddress.cepaberto_token',null);
        if(is_null($token)){
            Log::warning("CEPAberto token is not set! You should add CEPABERTO_TOKEN to your .env file");
            return ["statusText" => "token_not_set"];
        }

        $client = new Client();
        try{
            $response = $client->request('GET', 'https://www.cepaberto.com/api/v3/cep?cep='.$cep, [
                'headers' => [
                    'Authorization' => 'Token token='.$token,
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

        if($response->getStatusCode() != 200)
        {
            Log::warning("Couldn't fetch CEP due to a HTTP error, errorcode was: ".$response->getStatusCode());
            return ["statusText" => "http_error"];
        }


        $json = json_decode($response->getBody(),true);
        if(!array_key_exists("cidade", $json)){
            return ["statusText" => "invalid"];
        }
        return array_merge($json, ["statusText" => "ok"]);
    }
}
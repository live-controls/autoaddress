<?php
namespace LiveControls\AutoAddress\Scripts;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ZipCodebase
{
    public static function fromZip(string $zip, string $country)
    {
        $token = config('livecontrols_autoaddress.zipcodebase_token',null);
        if(is_null($token)){
            Log::warning("ZIPCODEBASE token is not set! You should add ZIPCODEBASE_TOKEN to your .env file");
            return ["statusText" => "token_not_set"];
        }

        $client = new Client();

        try{
            $response = $client->request('GET', 'https://api.zipcodestack.com/v1/search', [
                'headers' => [
                    'apikey' => $token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'codes'=> $zip,
                    'country'=> $country,
                ],
            ]);
        }catch(GuzzleException $ex)
        {
            Log::warning("Couldn\'t fetch ZIPCODEBASE Informations, server said: ".$ex->getMessage());
            return ["statusText" => "connection_error"];
        }catch(Exception $ex)
        {
            Log::warning("Couldn't fetch ZIPCODEBASE Informations due to an internal error, server said: ".$ex->getMessage());
            return ["statusText" => "internal_error"];
        }

        if($response->getStatusCode() != 200)
        {
            Log::warning("Couldn't fetch CEP due to a HTTP error, errorcode was: ".$response->getStatusCode());
            return ["statusText" => "http_error"];
        }
        
        $json = json_decode($response->getBody(),true);
        return array_merge($json, ["statusText" => "ok"]);
    }
}
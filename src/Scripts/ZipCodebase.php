<?php
namespace LiveControls\AutoAddress\Scripts;

use Illuminate\Support\Facades\Http;

class ZipCodebase
{
    public static function fromZip(string $zip, string $country)
    {
        $token = config('livecontrols_autoaddress.zipcodebase_token',null);
        if(is_null($token)){
            return ["statusText" => "token_not_set"];
        }

        $response = Http::withHeaders([
            'apikey' => $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('https://api.zipcodestack.com/v1/search', ['codes' => $zip, 'country' => $country]);
        

        if(! $response->ok())
        {
            return ["statusText" => "http_error"];
        }
        
        $json = json_decode($response->getBody(),true);
        return array_merge($json, ["statusText" => "ok"]);
    }
}
<?php

namespace App\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use Illuminate\Support\Facades\Cache;

class APIService
{
    public function fetchGeoInfo()
    {
        try{

            $minutes = 600;
            $geoInfo = Cache::remember('key', $minutes, function() {
                $baseURI =  config('app.ip_info_geo');
                $client = new \GuzzleHttp\Client([
                    'base_uri' => $baseURI
                ]);
                $response = $client->request('GET','');
                return json_decode($response->getBody(),true);
            });
            return $geoInfo;

        } catch (RequestException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

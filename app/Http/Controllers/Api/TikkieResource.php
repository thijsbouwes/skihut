<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class TikkieResource
{
    const API_KEY = '6s3zE8Mxg6aH1Bwy7CWVa79m1eoBpwVu';
    const API_URL = 'https://api.abnamro.com/v1/oauth/token';
    const API_ISS = 'Thijs Bouwes';

    public function GetToken()
    {
        $client = new Client();

        $payload = [
            "exp" => Carbon::now()->addMinute(15)->getTimestamp(),
            "nbf" => Carbon::now()->getTimestamp(),
            "iss" => self::API_ISS,
            "sub" => self::API_KEY,
            "aud" => 'https://auth-sandbox.abnamro.com/oauth/token'
        ];

        $signature = JWT::encode($payload, Storage::get('private_rsa.pem'), 'RS256');

        try {
            $response = $client->post(self::API_URL, [
                'headers' => [
                    'API-Key' => self::API_KEY
                ],
                'form_params' => [
                    'client_assertion' => $signature,
                    'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
                    'grant_type' => 'client_credentials'
                ]
            ]);
        } catch(GuzzleException $exception) {
            return $exception->getMessage();
        }

        return $response->getBody();
    }
}
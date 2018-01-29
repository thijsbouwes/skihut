<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class TikkieResource
{
    const TOKEN_ENDPOINT = 'oauth/token';

    public function GetToken()
    {
        $client = new Client([
            'base_uri' => config('tikkie.url')
        ]);

        $payload = [
            "exp" => Carbon::now()->addMinute(15)->getTimestamp(),
            "nbf" => Carbon::now()->getTimestamp(),
            "iss" => config('app.name'),
            "sub" => config('tikkie.key'),
            "aud" => 'https://auth-sandbox.abnamro.com/oauth/token'
        ];

        $signature = JWT::encode($payload, Storage::get('private_rsa.pem'), 'RS256');

        try {
            $response = $client->post(self::TOKEN_ENDPOINT, [
                'headers' => [
                    'API-Key' => config('tikkie.key')
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
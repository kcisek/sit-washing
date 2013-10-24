<?php

namespace Vikan\WashBundle;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\CurlException;

class MieleService
{
    const NETWORK_ERROR = 'Utilgjengelig';

    public function __construct()
    {
    }

    public function setLaundryState(&$laundryPlace)
    {
        $user = 'youruser';
        $pass = 'yourpassword';

        try {
            $client = new Client($laundryPlace['url']);
            $request = $client->get('/LaundryState', [], [
                'auth' => [$user, $pass, 'Digest'],
                'connect_timeout' => 1.5,
            ]);
            $response = $request->send();
            $laundryPlace['html'] = $body = $response->getBody();

            preg_match_all('/bgColor=Green/', $body, $greenMatches);
            preg_match_all('/bgColor=Red/', $body, $redMatches);
            $laundryPlace['busy'] = count($redMatches[0]);
            $laundryPlace['available'] = count($greenMatches[0]);
        } catch (CurlException $e) {
            $laundryPlace['available'] = self::NETWORK_ERROR;
            $laundryPlace['busy'] = self::NETWORK_ERROR;
            $laundryPlace['html'] = self::NETWORK_ERROR;
        }
    }

    public function getLaundryPlaces()
    {
        $laundryPlaces = [
            'moholt' => [
                'url' => "http://129.241.156.6/",
                'name' => "Moholt Alle 20",
            ],
            'moholt2' => [
                'url' => "http://129.241.128.7/",
                'name' => "Bregnevegen 65 / Aktivitetshuset på Moholt"
            ],
            'karinelund' => [
                'url' => "http://129.241.136.17/",
                'name' => "Karinelund"
            ],
            'berg' => [
                'url' => "http://129.241.126.11/",
                'name' => "Berg"
            ],
            'bloksberg' => [
                'url' => "http://129.241.158.20/",
                'name' => "Bloksberg"
            ],
            'nedre-singsakerslette' => [
                'url' => "http://129.241.124.32/",
                'name' => "Nedre Singsakerslette"
            ],
            'nedre-berg' => [
                'url' => "http://129.241.146.33/",
                'name' => "Nedre Berg"
            ],
            'steinan' => [
                'url' => "http://129.241.123.40/",
                'name' => "Steinan"
            ],
            'teknobyen' => [
                'url' => "http://129.241.152.11/",
                'name' => "Teknobyen"
            ],
            'lerkendal' => [
                'url' => "http://129.241.161.227",
                'name' => "Lerkendal"
            ]
        ];

        return $laundryPlaces;
    }

    public function getLaundrySiteBySlug($slug)
    {
        return $this->getLaundryPlaces()[3];
    }
}

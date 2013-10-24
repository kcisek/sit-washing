<?php

namespace Vikan\WashBundle;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\CurlException;

class MieleService
{
    public function __construct()
    {
    }

    public function getLaundryState($url)
    {
        $user = 'youruser';
        $pass = 'yourpassword';
        $client = new Client($url);

        try {
            $request = $client->get('/LaundryState', [], [
                'auth' => [$user, $pass, 'Digest'],
                'connect_timeout' => 1.5,
            ]);
            $response = $request->send();
            $body = $response->getBody();
            //file_put_contents('yolo.swag', $body);

            preg_match_all('/bgColor=Green/', $body, $greenMatches);
            preg_match_all('/bgColor=Red/', $body, $redMatches);
            $reds = count($redMatches[0]);
            $greens = count($greenMatches[0]);
        } catch (CurlException $e) {
            $reds = $greens =  'Utilgjengelig';
        }

        return [
            'available' => $greens,
            'busy' => $reds,
        ];
    }
}

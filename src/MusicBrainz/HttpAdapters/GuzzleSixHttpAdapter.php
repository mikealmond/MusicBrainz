<?php

namespace MusicBrainz\HttpAdapters;

use GuzzleHttp\ClientInterface;
use MusicBrainz\Exception;

class GuzzleSixHttpAdapter extends AbstractHttpAdapter
{
    private $client;

    public function __construct(ClientInterface $client, $endpoint = null)
    {
        $this->client = $client;

        if (filter_var($endpoint, FILTER_VALIDATE_URL)) {
            $this->endpoint = $endpoint;
        }
    }

    public function call($path, array $params = [], array $options = [], $isAuthRequired = false, $returnArray = false)
    {
        if ($options['user-agent'] == '') {
            throw new Exception('You must set a valid User Agent before accessing the MusicBrainz API');
        }

        $guzzleOptions = [
            'base_uri' => "{$this->endpoint}/",
            'headers' => [
                'Accept' => 'application/json',
                'User-Agent' => $options['user-agent'],
            ],
            'query' => $params,
        ];

        if ($isAuthRequired) {
            if ($options['user'] != null && $options['password'] != null) {
                $guzzleOptions['auth'] = [
                    $options['user'],
                    $options['password'],
                    'digest'
                ];
            } else {
                throw new Exception('Authentication is required');
            }
        }

        $request = $this->client->request('GET', $path, $guzzleOptions);

        // musicbrainz throttle
        sleep(1);

        return json_decode((string) $request->getBody(), $returnArray);
    }
}

<?php

namespace MusicBrainz\HttpAdapters;

use GuzzleHttp\ClientInterface;
use MusicBrainz\Exception;

/**
 * Guzzle Http Adapter
 */
class GuzzleHttpAdapter extends AbstractHttpAdapter
{
    /**
     * The Guzzle client used to make cURL requests
     *
     * @var \GuzzleHttp\ClientInterface
     */
    private $client;

    /**
     * Initializes the class.
     *
     * @param \GuzzleHttp\ClientInterface $client The Guzzle client used to make requests
     * @param null                         $endpoint Override the default endpoint (useful for local development)
     */
    public function __construct(ClientInterface $client, $endpoint = null)
    {
        $this->client = $client;

        if (filter_var($endpoint, FILTER_VALIDATE_URL)) {
            $this->endpoint = $endpoint;
        }
    }

    /**
     * Perform an HTTP request on MusicBrainz
     *
     * @param  string  $path
     * @param  array   $params
     * @param  array   $options
     * @param  boolean $isAuthRequired
     * @param  boolean $returnArray disregarded
     *
     * @throws \MusicBrainz\Exception
     * @return array
     */
    public function call($path, array $params = array(), array $options = array(), $isAuthRequired = false, $returnArray = false)
    {
        if ($options['user-agent'] == '') {
            throw new Exception('You must set a valid User Agent before accessing the MusicBrainz API');
        }

        $requestOptions = [
            'headers' => [
                'Accept' => 'application/json',
                'User-Agent' => $options['user-agent']
            ],
            'data' => $params
        ];

        if ($isAuthRequired) {
            if ($options['user'] != null && $options['password'] != null) {
                $requestOptions['auth'] = [
                    'user' => $options['user'],
                    'pass' => $options['password']
                ];
            } else {
                throw new Exception('Authentication is required');
            }
        }

        $response = $this->client->request('GET', $this->endpoint.'/'.$path, $requestOptions);

        $body = $response->getBody()->getContents();

        // musicbrainz throttle
        sleep(1);

        return \GuzzleHttp\json_decode($body, true);
    }
}

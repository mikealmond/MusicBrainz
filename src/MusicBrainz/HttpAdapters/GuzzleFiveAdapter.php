<?php
namespace MusicBrainz\HttpAdapters;

use GuzzleHttp\ClientInterface;
use MusicBrainz\Exception;

class GuzzleFiveAdapter extends AbstractHttpAdapter
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * Initialize class
     *
     * @param ClientInterface $client
     * @param null $endpoint
     */
    public function __client(ClientInterface $client, $endpoint = null)
    {
        $this->client = $client;

        if(filter_var($endpoint, FILTER_VALIDATE_URL)) {
            $this->endpoint = $endpoint;
        }
    }

    /**
     * Perform an HTTP request on MusicBrainz
     *
     * @param  string $path
     * @param  array $params
     * @param  array $options
     * @param  boolean $isAuthRequired
     * @param  boolean $returnArray
     *
     * @throws Exception
     * @return array
     */
    public function call($path, array $params = array(), array $options = array(), $isAuthRequired = false, $returnArray = false)
    {
        if($options['user-agent'] == '') {
            throw new Exception('You must set a valid User Agent before accessing the MusicBrainz API');
        }

        $requestOptions = [
            'headers'        => [
                'Accept'     => 'application/json',
                'User-Agent' => $options['user-agent']
            ]
        ];

        if ($isAuthRequired) {
            if ($options['user'] != null && $options['password'] != null) {
                $requestOptions['auth'] = [
                    'username' => $options['user'],
                    'password' => $options['password'],
                    CURLAUTH_DIGEST
                ];
            } else {
                throw new Exception('Authentication is required');
            }
        }

        $request = $this->client->createRequest('GET', $path . '{?data*}', $requestOptions);

        // musicbrainz throttle
        sleep(1);
        
        dump($this->client->send($request));

        return $request->send()->json();
    }
}
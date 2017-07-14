<?php

namespace MusicBrainz\Filters;

use MusicBrainz\MusicBrainz;

/**
 * Class FilterInterface
 * @package MusicBrainz\Filters
 */
interface FilterInterface
{
    /**
     * @return string
     */
    public function getEntity();

    /**
     * @param array $params
     *
     * @return array
     */
    public function createParameters(array $params = array());

    /**
     * @param array       $response
     * @param MusicBrainz $brainz
     *
     * @return mixed An array of the Filter's Music Brainz entity objects
     */
    public function parseResponse(array $response, MusicBrainz $brainz);
}

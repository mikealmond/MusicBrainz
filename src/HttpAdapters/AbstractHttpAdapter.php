<?php

namespace MusicBrainz\HttpAdapters;

/**
 * MusicBrainz HTTP Client interface
 */
abstract class AbstractHttpAdapter
{
    /**
     * @var string
     */
    public $endpoint = 'http://musicbrainz.org/ws/2';

    /**
     * Perform an HTTP request on MusicBrainz
     *
     * @param  string  $path
     * @param  array   $params
     * @param  array   $options
     * @param  boolean $isAuthRequired
     * @param  boolean $returnArray
     *
     * @return array
     */
    abstract public function call($path, array $params = array(), array $options = array(), $isAuthRequired = false, $returnArray = false);
}

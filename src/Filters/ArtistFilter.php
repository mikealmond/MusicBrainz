<?php

namespace MusicBrainz\Filters;

use MusicBrainz\Artist;
use MusicBrainz\MusicBrainz;

/**
 * This is the artist filter and it contains
 * an array of valid argument types to be used
 * when querying the MusicBrainz web service.
 */
class ArtistFilter extends AbstractFilter implements FilterInterface
{
    /**
     * @var array
     */
    protected $validArgTypes = array(
        'arid',
        'artist',
        'artistaccent',
        'alias',
        'begin',
        'comment',
        'country',
        'end',
        'ended',
        'gender',
        'ipi',
        'sortname',
        'tag',
        'type'
    );

    /**
     * @return string
     */
    public function getEntity()
    {
        return 'artist';
    }

    /**
     * @param array       $response
     * @param MusicBrainz $brainz
     *
     * @return Artist[]
     */
    public function parseResponse(array $response, MusicBrainz $brainz)
    {
        $artists = array();
        if (isset($response['artist'])) {
            foreach ($response['artist'] as $artist) {
                $artists[] = new Artist($artist, $brainz);
            }
        } elseif (isset($response['artists'])) {
            foreach ($response['artists'] as $artist) {
                $artists[] = new Artist($artist, $brainz);
            }
        }

        return $artists;
    }
}

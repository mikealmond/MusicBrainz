<?php

namespace MusicBrainz\Filters;

use MusicBrainz\MusicBrainz;
use MusicBrainz\Release;

/**
 * This is the release filter and it contains
 * an array of valid argument types to be used
 * when querying the MusicBrainz web service.
 */
class ReleaseFilter extends AbstractFilter implements FilterInterface
{
    /**
     * @var array
     */
    protected $validArgTypes = array(
        'arid',
        'artist',
        'artistname',
        'asin',
        'barcode',
        'catno',
        'comment',
        'country',
        'creditname',
        'date',
        'discids',
        'discidsmedium',
        'format',
        'laid',
        'label',
        'lang',
        'mediums',
        'primarytype',
        'puid',
        'reid',
        'release',
        'releaseaccent',
        'rgid',
        'script',
        'secondarytype',
        'status',
        'tag',
        'tracks',
        'tracksmedium',
        'type'
    );

    /**
     * @return string
     */
    public function getEntity()
    {
        return 'release';
    }

    /**
     * @param array       $response
     * @param MusicBrainz $brainz
     *
     * @return array
     */
    public function parseResponse(array $response, MusicBrainz $brainz)
    {
        $releases = array();
        if (isset($response['release'])) {
            foreach ($response['release'] as $release) {
                $releases[] = new Release($release, $brainz);
            }
        } elseif (isset($response['releases'])) {
            foreach ($response['releases'] as $release) {
                $releases[] = new Release($release, $brainz);
            }
        }

        return $releases;
    }
}

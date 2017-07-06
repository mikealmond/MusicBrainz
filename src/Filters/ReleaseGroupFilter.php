<?php

namespace MusicBrainz\Filters;

use MusicBrainz\Exception;
use MusicBrainz\MusicBrainz;
use MusicBrainz\ReleaseGroup;

/**
 * This is the release group filter and it contains
 * an array of valid argument types to be used
 * when querying the MusicBrainz web service.
 */
class ReleaseGroupFilter extends AbstractFilter implements FilterInterface
{
    protected $validArgTypes = array(
        'arid',
        'artist',
        'artistname',
        'comment',
        'creditname',
        'primarytype',
        'rgid',
        'releasegroup',
        'releasegroupaccent',
        'releases',
        'release',
        'reid',
        'secondarytype',
        'status',
        'tag',
        'type'
    );

    /**
     * @return string
     */
    public function getEntity()
    {
        return 'release-group';
    }

    /**
     * @param array       $response
     * @param MusicBrainz $brainz
     *
     * @throws \MusicBrainz\Exception
     * @return ReleaseGroup[]
     */
    public function parseResponse(array $response, MusicBrainz $brainz)
    {

        if (!isset($response['release-groups'])) {
            throw new Exception('No release groups found');
        }

        $releaseGroups = array();
        foreach ($response['release-groups'] as $releaseGroup) {
            $releaseGroups[] = new ReleaseGroup($releaseGroup, $brainz);
        }

        return $releaseGroups;
    }
}

<?php

namespace MusicBrainz\Filters;

use MusicBrainz\MusicBrainz;
use MusicBrainz\Tag;

/**
 * This is the tag filter and it contains
 * an array of valid argument types to be used
 * when querying the MusicBrainz web service.
 */
class TagFilter extends AbstractFilter implements FilterInterface
{
    protected $validArgTypes = array(
        'tag'
    );

    /**
     * @return string
     */
    public function getEntity()
    {
        return 'tag';
    }

    /**
     * @param array       $response
     * @param MusicBrainz $brainz
     *
     * @return Tag[]
     */
    public function parseResponse(array $response, MusicBrainz $brainz)
    {
        $tags = array();
        foreach ($response['tags'] as $tag) {
            $tags[] = new Tag($tag, $brainz);
        }

        return $tags;
    }
}

<?php

namespace MusicBrainz\Filters;

use MusicBrainz\Label;
use MusicBrainz\MusicBrainz;

/**
 * This is the label filter and it contains
 * an array of valid argument types to be used
 * when querying the MusicBrainz web service.
 */
class LabelFilter extends AbstractFilter implements FilterInterface
{
    /**
     * @var array
     */
    protected $validArgTypes = array(
        'aliaas',
        'begin',
        'code',
        'comment',
        'country',
        'end',
        'ended',
        'ipi',
        'label',
        'labelaccent',
        'laid',
        'sortname',
        'tag',
        'type'
    );

    /**
     * @return string
     */
    public function getEntity()
    {
        return 'label';
    }

    /**
     * @param array       $response
     * @param MusicBrainz $brainz
     *
     * @return Label[]
     */
    public function parseResponse(array $response, MusicBrainz $brainz)
    {
        $labels = array();

        foreach ($response['labels'] as $label) {
            $labels[] = new Label($label, $brainz);
        }

        return $labels;
    }
}

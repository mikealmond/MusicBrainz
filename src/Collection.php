<?php

namespace MusicBrainz;

/**
 * Represents a MusicBrainz collection object
 * @package MusicBrainz
 */
class Collection
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var array
     */
    private $data;
    /**
     * @var MusicBrainz
     */
    private $brainz;

    /**
     * @param array       $collection
     * @param MusicBrainz $brainz
     */
    public function __construct(array $collection, MusicBrainz $brainz)
    {
        $this->data   = $collection;
        $this->brainz = $brainz;

        $this->id = isset($collection['id']) ? (string)$collection['id'] : '';
    }
}

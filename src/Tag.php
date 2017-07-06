<?php

namespace MusicBrainz;

/**
 * Represents a MusicBrainz tag object
 * @package MusicBrainz
 */
class Tag
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $score;
    /**
     * @var array
     */
    private $data;

    /**
     * @param array       $tag
     * @param MusicBrainz $brainz
     */
    public function __construct(array $tag, MusicBrainz $brainz)
    {
        $this->data   = $tag;
        $this->brainz = $brainz;

        $this->name  = isset($tag['name']) ? (string)$tag['name'] : '';
        $this->score = isset($tag['score']) ? (string)$tag['score'] : '';
    }
}

<?php

namespace MusicBrainz;

/**
 * Represents a MusicBrainz label object
 */
class Label
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var array
     */
    public $aliases;
    /**
     * @var int
     */
    public $score;
    /**
     * @var string
     */
    public $sortName;
    /**
     * @var string
     */
    public $country;

    /**
     * @var array
     */
    private $data;

    /**
     * @param array       $label
     * @param MusicBrainz $brainz
     */
    public function __construct(array $label, MusicBrainz $brainz)
    {
        $this->data   = $label;
        $this->brainz = $brainz;

        $this->id       = isset($label['id']) ? (string)$label['id'] : '';
        $this->type     = isset($label['type']) ? (string)$label['type'] : '';
        $this->score    = isset($label['score']) ? (int)$label['score'] : 0;
        $this->sortName = isset($label['sort-name']) ? (string)$label['sort-name'] : '';
        $this->name     = isset($label['name']) ? (string)$label['name'] : '';
        $this->country  = isset($label['country']) ? (string)$label['country'] : '';
        $this->aliases  = isset($label['aliases']) ? $label['aliases'] : array();
    }
}

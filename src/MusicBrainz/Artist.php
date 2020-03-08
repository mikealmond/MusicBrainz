<?php

namespace MusicBrainz;

/**
 * Represents a MusicBrainz artist object
 * @package MusicBrainz
 */
class Artist
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
     * @var MusicBrainz
     */
    protected $brainz;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $sortName;
    /**
     * @var string
     */
    private $gender;
    /**
     * @var string
     */
    private $country;
    /**
     * @var string
     */
    private $beginDate;
    /**
     * @var string
     */
    private $endDate;
    /**
     * @var array
     */
    private $data;
    /**
     * @var array
     */
    private $releases;

    /**
     * @param array       $artist
     * @param MusicBrainz $brainz
     *
     * @throws Exception
     */
    public function __construct(array $artist, MusicBrainz $brainz)
    {
        if (!isset($artist['id']) || isset($artist['id']) && !$brainz->isValidMBID($artist['id'])) {
            throw new Exception('Can not create artist object. Missing valid MBID');
        }

        $this->data   = $artist;
        $this->brainz = $brainz;

        $this->id        = isset($artist['id']) ? (string)$artist['id'] : '';
        $this->type      = isset($artist['type']) ? (string)$artist['type'] : '';
        $this->name      = isset($artist['name']) ? (string)$artist['name'] : '';
        $this->sortName  = isset($artist['sort-name']) ? (string)$artist['sort-name'] : '';
        $this->gender    = isset($artist['gender']) ? (string)$artist['gender'] : '';
        $this->country   = isset($artist['country']) ? (string)$artist['country'] : '';
        $this->beginDate = isset($artist['life-span']['begin']) ? $artist['life-span']['begin'] : null;
        $this->endDate   = isset($artist['life-span']['ended']) ? $artist['life-span']['ended'] : null;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return isset($this->data['score']) ? (int)$this->data['score'] : 0;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getReleases()
    {
        if (null === $this->releases) {
            $this->releases = $this->brainz->browseRelease('artist', $this->getId());
        }

        return $this->releases;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get artist data
     *
     * @return array
     */
    public function getData() {
        return $this->data;
    }
}


<?php

namespace MusicBrainz;

/**
 * Represents a MusicBrainz release group
 *
 */
class ReleaseGroup
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $primaryType;
    /**
     * @var array
     */
    public $secondaryTypes = array();
    /**
     * @var array
     */
    private $data;
    /**
     * @var MusicBrainz
     */
    private $brainz;
    /**
     * @var Release[]
     */
    private $releases = array();

    /**
     * @param array       $releaseGroup
     * @param MusicBrainz $brainz
     */
    public function __construct(array $releaseGroup, MusicBrainz $brainz)
    {
        $this->data   = $releaseGroup;
        $this->brainz = $brainz;

        $this->id             = isset($releaseGroup['id']) ? (string)$releaseGroup['id'] : '';
        $this->primaryType    = isset($releaseGroup['primary-type']) ? (string)$releaseGroup['primary-type'] : '';
        $this->secondaryTypes = isset($releaseGroup['secondary-types']) ? $releaseGroup['secondary-types'] : array();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->data['title'];
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->data['score'];
    }

    /**
     * @return Release[]
     */
    public function getReleases()
    {
        if (!empty($this->releases)) {
            return $this->releases;
        }

        foreach ($this->data['releases'] as $release) {
            array_push($this->releases, new Release($release, $this->brainz));
        }

        return $this->releases;
    }
}

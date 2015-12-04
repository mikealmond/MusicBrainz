<?php

namespace MusicBrainz;

/**
 * Represents a MusicBrainz Recording object
 * @package MusicBrainz
 */
class Recording
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $title;
    /**
     * @var int
     */
    public $score;
    /**
     * @var Artist[]
     */
    public $artists = array();
    /**
     * @var Release[]
     */
    public $releases = array();
    /**
     * @var array
     */
    private $data;

    /**
     * @param array       $recording
     * @param MusicBrainz $brainz
     */
    public function __construct(array $recording, MusicBrainz $brainz)
    {
        $this->data   = $recording;
        $this->brainz = $brainz;

        $this->id       = (string)$recording['id'];
        $this->title    = (string)$recording['title'];
        $this->length   = (isset($recording['length'])) ? (int)$recording['length'] : 0;
        $this->score    = (isset($recording['score'])) ? (int)$recording['score'] : 0;

        if (isset($recording['artist-credit'])) {
            $this->setArtists($recording['artist-credit']);
        }

        if (isset($recording['releases'])) {
            $this->setReleases($recording['releases']);
        }
    }

    /**
     * @param array $releases
     *
     * @return $this
     */
    public function setReleases(array $releases)
    {
        foreach ($releases as $release) {
            array_push($this->releases, new Release($release, $this->brainz));
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @throws Exception
     * @return array
     */
    public function getReleaseDates()
    {

        if (empty($this->releases)) {
            throw new Exception('Could not find any releases in the recording');
        }

        $releaseDates = array();

        foreach ($this->releases as $release) {
            /** @var Release $release */
            array_push($releaseDates, $release->getReleaseDate());
        }

        asort($releaseDates);

        return $releaseDates;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param array $artists
     *
     * @return $this
     */
    public function setArtists(array $artists)
    {
        foreach ($artists as $artist) {
            array_push($this->artists, new Artist($artist["artist"], $this->brainz));
        }

        return $this;
    }

    /**
     * @return Artist
     */
    public function getArtist()
    {
        return ($this->getArtists()?$this->getArtists()[0]:null);
    }

    /**
     * @return Artist[]
     */
    public function getArtists()
    {
        if (!$this->artists) {
            $includes = array(
                'artists',
            );

            $release = $this->brainz->lookup('release', $this->getId(), $includes);
            $this->setArtists($release['artist-credit']);
        }
        return $this->artists;
    }

    /**
     * @param string $format
     *
     * @return int|string
     */
    public function getLength($format = 'int')
    {
        switch ($format) {
            case 'short':
                return str_replace('.', ':', number_format(($this->length / 1000 / 60), 2));
                break;
            case 'long':
                return str_replace('.', 'm ', number_format(($this->length / 1000 / 60), 2)) . 's';
                break;
            case 'int':
            default:
                return $this->length;
        }
    }
}

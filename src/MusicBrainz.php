<?php

namespace MusicBrainz;

use MusicBrainz\HttpAdapters\AbstractHttpAdapter;

/**
 * Connect to the MusicBrainz web service
 *
 * http://musicbrainz.org/doc/Development
 *
 * @link http://github.com/mikealmond/musicbrainz
 * @package MusicBrainz
 */
class MusicBrainz
{
    /**
     * @var array
     */
    private static $validIncludes = array(
        'artist'        => array(
            "recordings",
            "releases",
            "release-groups",
            "works",
            "various-artists",
            "discids",
            "media",
            "aliases",
            "tags",
            "user-tags",
            "ratings",
            "user-ratings", // misc
            "artist-rels",
            "label-rels",
            "recording-rels",
            "release-rels",
            "release-group-rels",
            "url-rels",
            "work-rels",
            "annotation"
        ),
        'annotation'    => array(),
        'label'         => array(
            "releases",
            "discids",
            "media",
            "aliases",
            "tags",
            "user-tags",
            "ratings",
            "user-ratings", // misc
            "artist-rels",
            "label-rels",
            "recording-rels",
            "release-rels",
            "release-group-rels",
            "url-rels",
            "work-rels",
            "annotation"
        ),
        'recording'     => array(
            "artists",
            "releases", // sub queries
            "discids",
            "media",
            "artist-credits",
            "tags",
            "user-tags",
            "ratings",
            "user-ratings", // misc
            "artist-rels",
            "label-rels",
            "recording-rels",
            "release-rels",
            "release-group-rels",
            "url-rels",
            "work-rels",
            "annotation",
            "aliases"
        ),
        'release'       => array(
            "artists",
            "labels",
            "recordings",
            "release-groups",
            "media",
            "artist-credits",
            "discids",
            "puids",
            "echoprints",
            "isrcs",
            "artist-rels",
            "label-rels",
            "recording-rels",
            "release-rels",
            "release-group-rels",
            "url-rels",
            "work-rels",
            "recording-level-rels",
            "work-level-rels",
            "annotation",
            "aliases"
        ),
        'release-group' => array(
            "artists",
            "releases",
            "discids",
            "media",
            "artist-credits",
            "tags",
            "user-tags",
            "ratings",
            "user-ratings", // misc
            "artist-rels",
            "label-rels",
            "recording-rels",
            "release-rels",
            "release-group-rels",
            "url-rels",
            "work-rels",
            "annotation",
            "aliases"
        ),
        'work'          => array(
            "artists", // sub queries
            "aliases",
            "tags",
            "user-tags",
            "ratings",
            "user-ratings", // misc
            "artist-rels",
            "label-rels",
            "recording-rels",
            "release-rels",
            "release-group-rels",
            "url-rels",
            "work-rels",
            "annotation"
        ),
        'discid'        => array(
            "artists",
            "labels",
            "recordings",
            "release-groups",
            "media",
            "artist-credits",
            "discids",
            "puids",
            "echoprints",
            "isrcs",
            "artist-rels",
            "label-rels",
            "recording-rels",
            "release-rels",
            "release-group-rels",
            "url-rels",
            "work-rels",
            "recording-level-rels",
            "work-level-rels"
        ),
        'echoprint'     => array(
            "artists",
            "releases"
        ),
        'puid'          => array(
            "artists",
            "releases",
            "puids",
            "echoprints",
            "isrcs"
        ),
        'isrc'          => array(
            "artists",
            "releases",
            "puids",
            "echoprints",
            "isrcs"
        ),
        'iswc'          => array(
            "artists"
        ),
        'collection'    => array(
            'releases'
        )
    );
    /**
     * @var array
     */
    private static $validBrowseIncludes = array(
        'release'       => array(
            "artist-credits",
            "labels",
            "recordings",
            "release-groups",
            "media",
            "discids",
            "artist-rels",
            "label-rels",
            "recording-rels",
            "release-rels",
            "release-group-rels",
            "url-rels",
            "work-rels"
        ),
        'recording'     => array(
            "artist-credits",
            "tags",
            "ratings",
            "user-tags",
            "user-ratings"
        ),
        'label'         => array(
            "aliases",
            "tags",
            "ratings",
            "user-tags",
            "user-ratings"
        ),
        'artist'        => array(
            "aliases",
            "tags",
            "ratings",
            "user-tags",
            "user-ratings"
        ),
        'release-group' => array(
            "artist-credits",
            "tags",
            "ratings",
            "user-tags",
            "user-ratings"
        )
    );
    /**
     * @var array
     */
    private static $validReleaseTypes = array(
        "nat",
        "album",
        "single",
        "ep",
        "compilation",
        "soundtrack",
        "spokenword",
        "interview",
        "audiobook",
        "live",
        "remix",
        "other"
    );
    /**
     * @var array
     */
    private static $validReleaseStatuses = array(
        "official",
        "promotion",
        "bootleg",
        "pseudo-release"
    );
    /**
     * @var string
     */
    private $userAgent = 'MusicBrainz PHP Api/0.2.0';
    /**
     * The username a MusicBrainz user. Used for authentication.
     *
     * @var string
     */
    private $user = null;
    /**
     * The password of a MusicBrainz user. Used for authentication.
     *
     * @var string
     */
    private $password = null;
    /**
     * The Http adapter used to make requests
     *
     * @var \MusicBrainz\HttpAdapters\AbstractHttpAdapter
     */
    private $adapter;

    /**
     * Initializes the class. You can pass the user’s username and password
     * However, you can modify or add all values later.
     *
     * @param HttpAdapters\AbstractHttpAdapter $adapter The Http adapter used to make requests
     * @param string                           $user
     * @param string                           $password
     */
    public function __construct(AbstractHttpAdapter $adapter, $user = null, $password = null)
    {
        $this->adapter = $adapter;

        if (null != $user) {
            $this->setUser($user);
        }

        if (null != $password) {
            $this->setPassword($password);
        }
    }

    /**
     * Do a MusicBrainz lookup
     *
     * http://musicbrainz.org/doc/XML_Web_Service
     *
     * @param string $entity
     * @param string $mbid Music Brainz ID
     * @param array  $includes
     *
     * @throws Exception
     * @return array
     */
    public function lookup($entity, $mbid, array $includes = array())
    {

        if (!$this->isValidEntity($entity)) {
            throw new Exception('Invalid entity');
        }

        $this->validateInclude($includes, self::$validIncludes[$entity]);

        $authRequired = $this->isAuthRequired($entity, $includes);

        $params = array(
            'inc' => implode('+', $includes),
            'fmt' => 'json'
        );

        $response = $this->adapter->call($entity . '/' . $mbid, $params, $this->getHttpOptions(), $authRequired);

        return $response;
    }

    /**
     * @param Filters\FilterInterface $filter
     * @param                         $entity
     * @param                         $mbid
     * @param array                   $includes
     * @param int                     $limit
     * @param null                    $offset
     * @param array                   $releaseType
     * @param array                   $releaseStatus
     *
     * @return array
     * @throws Exception
     */
    protected function browse(
        Filters\FilterInterface $filter,
        $entity,
        $mbid,
        array $includes,
        $limit = 25,
        $offset = null,
        $releaseType = array(),
        $releaseStatus = array()
    ) {
        if (!$this->isValidMBID($mbid)) {
            throw new Exception('Invalid Music Brainz ID');
        }

        if ($limit > 100) {
            throw new Exception('Limit can only be between 1 and 100');
        }

        $this->validateInclude($includes, self::$validBrowseIncludes[$filter->getEntity()]);

        $authRequired = $this->isAuthRequired($filter->getEntity(), $includes);

        $params = $this->getBrowseFilterParams($filter->getEntity(), $includes, $releaseType, $releaseStatus);
        $params += array(
            $entity  => $mbid,
            'inc'    => implode('+', $includes),
            'limit'  => $limit,
            'offset' => $offset,
            'fmt'    => 'json'
        );

        $response = $this->adapter->call($filter->getEntity() . '/', $params, $this->getHttpOptions(), $authRequired);

        return $response;
    }

    /**
     * @param       $entity
     * @param       $mbid
     * @param array $includes
     * @param int   $limit
     * @param null  $offset
     *
     * @return array
     * @throws Exception
     */
    public function browseArtist($entity, $mbid, array $includes = array(), $limit = 25, $offset = null)
    {
        if (!in_array($entity, array('recording', 'release', 'release-group'))) {
            throw new Exception('Invalid browse entity for artist');
        }

        return $this->browse(new Filters\ArtistFilter(array()), $entity, $mbid, $includes, $limit, $offset);
    }

    /**
     * @param       $entity
     * @param       $mbid
     * @param array $includes
     * @param int   $limit
     * @param null  $offset
     *
     * @return array
     * @throws Exception
     */
    public function browseLabel($entity, $mbid, array $includes, $limit = 25, $offset = null)
    {
        if (!in_array($entity, array('release'))) {
            throw new Exception('Invalid browse entity for label');
        }

        return $this->browse(new Filters\LabelFilter(array()), $entity, $mbid, $includes, $limit, $offset);
    }

    /**
     * @param       $entity
     * @param       $mbid
     * @param array $includes
     * @param int   $limit
     * @param null  $offset
     *
     * @return array
     * @throws Exception
     */
    public function browseRecording($entity, $mbid, array $includes = array(), $limit = 25, $offset = null)
    {
        if (!in_array($entity, array('artist', 'release'))) {
            throw new Exception('Invalid browse entity for recording');
        }

        return $this->browse(new Filters\RecordingFilter(array()), $entity, $mbid, $includes, $limit, $offset);
    }

    /**
     * @param       $entity
     * @param       $mbid
     * @param array $includes
     * @param int   $limit
     * @param null  $offset
     * @param array $releaseType
     * @param array $releaseStatus
     *
     * @return array
     * @throws Exception
     */
    public function browseRelease(
        $entity,
        $mbid,
        array $includes = array(),
        $limit = 25,
        $offset = null,
        $releaseType = array(),
        $releaseStatus = array()
    ) {
        if (!in_array($entity, array('artist', 'label', 'recording', 'release-group'))) {
            throw new Exception('Invalid browse entity for release');
        }

        return $this->browse(
            new Filters\ReleaseFilter(array()),
            $entity,
            $mbid,
            $includes,
            $limit,
            $offset,
            $releaseType,
            $releaseStatus
        );
    }

    /**
     * @param       $entity
     * @param       $mbid
     * @param int   $limit
     * @param null  $offset
     * @param array $includes
     * @param array $releaseType
     *
     * @return array
     * @throws Exception
     */
    public function browseReleaseGroup(
        $entity,
        $mbid,
        $limit = 25,
        $offset = null,
        array $includes,
        $releaseType = array()
    ) {
        if (!in_array($entity, array('artist', 'release'))) {
            throw new Exception('Invalid browse entity for release group');
        }

        return $this->browse(
            new Filters\ReleaseGroupFilter(array()),
            $entity,
            $mbid,
            $includes,
            $limit,
            $offset,
            $releaseType
        );
    }

    /**
     * Performs a query based on the parameters supplied in the Filter object.
     * Returns an array of possible matches with scores, as returned by the
     * musicBrainz web service.
     *
     * Note that these types of queries only return some information, and not all the
     * information available about a particular item is available using this type of query.
     * You will need to get the MusicBrainz id (mbid) and perform a lookup with browse
     * to return complete information about a release. This method returns an array of
     * objects that are possible matches.
     *
     * @param Filters\FilterInterface $filter
     * @param int                     $limit
     * @param null|int                $offset
     *
     * @throws Exception
     * @return array
     */
    public function search(Filters\FilterInterface $filter, $limit = 25, $offset = null)
    {
        if (count($filter->createParameters()) < 1) {
            throw new Exception('The artist filter object needs at least 1 argument to create a query.');
        }

        if ($limit > 100) {
            throw new Exception('Limit can only be between 1 and 100');
        }

        $params = $filter->createParameters(array('limit' => $limit, 'offset' => $offset, 'fmt' => 'json'));

        $response = $this->adapter->call($filter->getEntity() . '/', $params, $this->getHttpOptions(), false, true);

        return $filter->parseResponse($response, $this);
    }

    /**
     * @param $mbid
     *
     * @return int
     */
    public function isValidMBID($mbid)
    {
        return preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/i", $mbid);
    }

    /**
     * Check the list of allowed entities
     *
     * @param $entity
     *
     * @return bool
     */
    private function isValidEntity($entity)
    {
        return array_key_exists($entity, self::$validIncludes);
    }

    /**
     * Some calls require authentication
     *
     * @param $entity
     * @param $includes
     *
     * @return bool
     */
    protected function isAuthRequired($entity, $includes)
    {
        if (in_array('user-tags', $includes) || in_array('user-ratings', $includes)) {
            return true;
        }

        if (substr($entity, 0, strlen('collection')) === 'collection') {
            return true;
        }

        return false;
    }

    /**
     * @param $includes
     * @param $validIncludes
     *
     * @return bool
     * @throws \OutOfBoundsException
     */
    public function validateInclude($includes, $validIncludes)
    {
        foreach ($includes as $include) {
            if (!in_array($include, $validIncludes)) {
                throw new \OutOfBoundsException(sprintf('%s is not a valid include', $include));
            }
        }

        return true;
    }

    /**
     * @param $values
     * @param $valid
     *
     * @return bool
     * @throws Exception
     */
    public function validateFilter($values, $valid)
    {
        foreach ($values as $value) {
            if (!in_array($value, $valid)) {
                throw new Exception(sprintf('%s is not a valid filter', $value));
            }
        }

        return true;
    }

    /**
     * Check that the status or type values are valid. Then, check that
     * the filters can be used with the given includes.
     *
     * @param  string $entity
     * @param  array  $includes
     * @param  array  $releaseType
     * @param  array  $releaseStatus
     *
     * @throws Exception
     * @return array
     */
    public function getBrowseFilterParams(
        $entity,
        $includes,
        array $releaseType = array(),
        array $releaseStatus = array()
    ) {
        //$this->validateFilter(array($entity), self::$validIncludes);
        $this->validateFilter($releaseStatus, self::$validReleaseStatuses);
        $this->validateFilter($releaseType, self::$validReleaseTypes);

        if (!empty($releaseStatus)
            && !in_array('releases', $includes)
        ) {
            throw new Exception("Can't have a status with no release include");
        }

        if (!empty($releaseType)
            && !in_array('release-groups', $includes)
            && !in_array('releases', $includes)
            && $entity != 'release-group'
        ) {
            throw new Exception("Can't have a release type with no release-group include");
        }

        $params = array();

        if (!empty($releaseType)) {
            $params['type'] = implode('|', $releaseType);
        }

        if (!empty($releaseStatus)) {
            $params['status'] = implode('|', $releaseStatus);
        }

        return $params;
    }

    /**
     * @return array
     */
    public function getHttpOptions()
    {
        return array(
            'method'     => 'GET',
            'user-agent' => $this->getUserAgent(),
            'user'       => $this->getUser(),
            'password'   => $this->getPassword()
        );
    }

    /**
     * Returns the user agent.
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set the user agent for POST requests (and GET requests for user tags)
     *
     * @param string $application The name of the application using this library
     * @param string $version The version of the application using this library
     * @param string $contactInfo E-mail or website of the application
     *
     * @throws Exception
     */
    public function setUserAgent($application, $version, $contactInfo)
    {
        if (strpos($version, '-') !== false) {
            throw new Exception('User agent: version should not contain a "-" character.');
        }

        $this->userAgent = $application . '/' . $version . ' (' . $contactInfo . ')';
    }

    /**
     * Returns the MusicBrainz user
     *
     * @return null|string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the MusicBrainz user
     *
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Returns the user’s password
     *
     * @return null|string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the user’s password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}

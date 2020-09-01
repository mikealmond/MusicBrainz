<pre><?php

use GuzzleHttp\Client;
use MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use MusicBrainz\MusicBrainz;

require dirname(__DIR__) . '/vendor/autoload.php';

// Create new MusicBrainz object
$brainz = new MusicBrainz(new GuzzleHttpAdapter(new Client()));
$brainz->setUserAgent('ApplicationName', '0.2', 'http://example.com');

/**
 * Lookup an Artist and include a list of Releases, Recordings, Release Groups and User Ratings
 * Note: You must be logged in to retrieve user-ratings
 * @see http://musicbrainz.org/doc/Artist
 */
$includes = array(
    'releases',
    'recordings',
    'release-groups',
    'user-ratings'
);
try {
    $artist = $brainz->lookup('artist', '4dbf5678-7a31-406a-abbe-232f8ac2cd63', $includes);
    print_r($artist);
} catch (Exception $e) {
    print $e->getMessage();
}
print "\n\n";


/**
 * Lookup a Release Group based on an MBID
 * @see http://musicbrainz.org/doc/Release_Group
 */
try {
    //born this way: the remix
    $releaseGroup = $brainz->lookup('release-group', 'e4307c5f-1959-4163-b4b1-ded4f9d786b0');
    print_r($releaseGroup);
} catch (Exception $e) {
    echo $e->getMessage();
}

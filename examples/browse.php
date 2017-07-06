<pre><?php

use GuzzleHttp\Client;
use MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use MusicBrainz\MusicBrainz;

require dirname(__DIR__) . '/vendor/autoload.php';

// Create new MusicBrainz object
$brainz = new MusicBrainz(new GuzzleHttpAdapter(new Client()));
$brainz->setUserAgent('ApplicationName', '0.2', 'http://example.com');


/**
 * Browse Releases based on an Artist MBID (Weezer in this case)
 * Include the Labels for the Release and the Recordings in it
 */
$includes = array('labels', 'recordings');
try {
    $details = $brainz->browseRelease('artist', '6fe07aa5-fec0-4eca-a456-f29bff451b04', $includes, 2);
    print_r($details);
} catch (Exception $e) {
    print $e->getMessage();
}
print "\n\n";


/**
 * Browse an artist based on a Recording MBID and include their aliases and ratings
 */
$includes = array('aliases', 'ratings');
try {
    $details = $brainz->browseArtist('recording', 'd615590b-1546-441d-9703-b3cf88487cbd', $includes);
    print_r($details);
} catch (Exception $e) {
    print $e->getMessage();
}
print "\n\n";


/**
 * Browse information for a Label based on an Artist's MBID
 */
$includes = array('aliases');
try {
    $details = $brainz->browseLabel('artist', '6fe07aa5-fec0-4eca-a456-f29bff451b04', $includes);
    print_r($details);
} catch (Exception $e) {
    print $e->getMessage();
}
print "\n\n";


/**
 * Browse information for a Label based on a Release's MBID
 */
$includes = array('aliases');
try {
    $details = $brainz->browseLabel('release', 'b072b162-a733-3137-a4a0-4375172d98c9', $includes);
    print_r($details);
} catch (Exception $e) {
    print $e->getMessage();
}

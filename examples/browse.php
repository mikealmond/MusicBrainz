<pre><?php

use MusicBrainz\MusicBrainz;
use MusicBrainz\Clients\GuzzleMbClient;
use Guzzle\Http\Client;

require_once '../vendor/autoload.php';

//Create new phpBrainz object
$brainz = new MusicBrainz(new GuzzleMbClient(new Client()));
$brainz->setUserAgent('ApplicationName', '0.1', 'http://example.com');

$includes = array('labels', 'recordings');
try {
    $details = $brainz->browseRelease('artist', '6fe07aa5-fec0-4eca-a456-f29bff451b04', $includes, 2);
    print_r($details);
} catch (Exception $e) {
    print $e->getMessage();
}

print "\n\n";

$includes = array('aliases', 'ratings');
try {
    $details = $brainz->browseArtist('recording', 'd615590b-1546-441d-9703-b3cf88487cbd', $includes);
    print_r($details);
} catch (Exception $e) {
    print $e->getMessage();
}

print "\n\n";

$includes = array('aliases');
try {
    $details = $brainz->browseLabel('artist', '6fe07aa5-fec0-4eca-a456-f29bff451b04', $includes);
    print_r($details);
} catch (Exception $e) {
    print $e->getMessage();
}

print "\n\n";

$includes = array('aliases');
try {
    $details = $brainz->browseLabel('release', 'b072b162-a733-3137-a4a0-4375172d98c9', $includes);
    print_r($details);
} catch (Exception $e) {
    print $e->getMessage();
}

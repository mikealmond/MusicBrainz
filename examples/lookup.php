<pre><?php

use MusicBrainz\MusicBrainz;
use MusicBrainz\Clients\GuzzleMbClient;
use Guzzle\Http\Client;

require_once '../vendor/autoload.php';

//Create new phpBrainz object
$brainz = new MusicBrainz(new GuzzleMbClient(new Client()), 'username', 'password');
$brainz->setUserAgent('ApplicationName', '0.1', 'http://example.com');

$includes = array(
    'releases',
    'recordings',
    'release-groups',
    'user-ratings'
);
try {
    $artist = $brainz->lookup('artist', '4dbf5678-7a31-406a-abbe-232f8ac2cd63', $includes);  //bryan adams
    print_r($artist);
} catch (Exception $e) {
    print $e->getMessage();
}

print "\n\n";

try {
    //born this way: the remix
    $releaseGroup = $brainz->lookup('release-group', 'e4307c5f-1959-4163-b4b1-ded4f9d786b0');
    print_r($releaseGroup);
} catch (Exception $e) {
    echo $e->getMessage();
}

<pre><?php

use MusicBrainz\MusicBrainz;
use MusicBrainz\Clients\GuzzleMbClient;
use MusicBrainz\Filters\ArtistFilter;
use MusicBrainz\Filters\RecordingFilter;
use MusicBrainz\Filters\LabelFilter;
use Guzzle\Http\Client;

require_once '../vendor/autoload.php';

//Create new phpBrainz object
$brainz = new MusicBrainz(new GuzzleMbClient(new Client()));
$brainz->setUserAgent('ApplicationName', '0.1', 'http://example.com');

$args = array(
    "artist"     => 'Weezer'
);
try {
    $artists = $brainz->search(new ArtistFilter($args));
    print_r($artists);
} catch (Exception $e) {
    print $e->getMessage();
}

print "\n\n";

$args = array(
    "recording"  => "Buddy Holly",
    "artist"     => 'Weezer',
    "creditname" => 'Weezer',
    "status"     => 'Official'
);
try {
    $recordings = $brainz->search(new RecordingFilter($args));
    print_r($recordings);
} catch (Exception $e) {
    print $e->getMessage();
}

print "\n\n";

$args = array(
    "label"  => "Devils"
);
try {
    $labels = $brainz->search(new LabelFilter($args));
    print_r($labels);
} catch (Exception $e) {
    print $e->getMessage();
}

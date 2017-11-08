<?php

use GuzzleHttp\Client;
use MusicBrainz\MusicBrainz;
use MusicBrainz\Filters\ArtistFilter;
use MusicBrainz\HttpAdapters\GuzzleSixHttpAdapter;

// Tested with guzzle 6.3.0
$musicBrainz = new MusicBrainz(new GuzzleSixHttpAdapter(new Client()));
$musicBrainz->setUserAgent('ApplicationName', '0.2', 'http://example.com');

try {
    $artist = $musicBrainz->search(new ArtistFilter([ "artist" => 'Weezer' ]));
    print_r($artist);
} catch (\Exception $e) {
    print $e->getMessage();
}
print "\n\n";

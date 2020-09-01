# MusicBrainz Web Service (v2) PHP class

This PHP library that allows you to easily access the MusicBrainz Web Service V2 API. Visit the [MusicBrainz development page](http://musicbrainz.org/doc/Development) for more information.

This project is a fork of https://github.com/chrisdawson/MusicBrainz and takes some inspiration from the [Python bindings](https://github.com/alastair/python-musicbrainz-ngs)

## Usage Example


```php
<?php
    use GuzzleHttp\Client;
    use MusicBrainz\Filters\ArtistFilter;
    use MusicBrainz\Filters\RecordingFilter;
    use MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
    use MusicBrainz\MusicBrainz;

    require __DIR__ . '/vendor/autoload.php';

    $brainz = new MusicBrainz(new GuzzleHttpAdapter(new Client()), 'username', 'password');
    $brainz->setUserAgent('ApplicationName', '0.2', 'http://example.com');

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
?>
```

Look in the [/examples](https://github.com/mikealmond/MusicBrainz/tree/master/examples) folder for more.

## Requirements
PHP5 and [cURL extension](http://php.net/manual/en/book.curl.php).


## License

**Short:** Use it in any project, no matter if it is commercial or not. Just don't remove the copyright notice.

**MIT License**

Copyright © 2015 Mike Almond

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

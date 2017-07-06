<?php

namespace MusicBrainz\Tests;

use MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use MusicBrainz\MusicBrainz;

/**
 * @covers MusicBrainz\MusicBrainz
 */
class MusicBrainzTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \MusicBrainz\MusicBrainz
     */
    protected $brainz;

    public function setUp()
    {
        /** @noinspection PhpParamsInspection */
        $this->brainz = new MusicBrainz(new GuzzleHttpAdapter($this->getMock('\Guzzle\Http\ClientInterface')));
    }

    /**
     * @return array
     */
    public function MBIDProvider()
    {
        return array(
            array(true, '4dbf5678-7a31-406a-abbe-232f8ac2cd63'),
            array(true, '4dbf5678-7a31-406a-abbe-232f8ac2cd63'),
            array(false, '4dbf5678-7a314-06aabb-e232f-8ac2cd63'), // invalid spacing for UUID's
            array(false, '4dbf5678-7a31-406a-abbe-232f8az2cd63') // z is an invalid character
        );
    }

    /**
     * @dataProvider MBIDProvider
     */
    public function testIsValidMBID($validation, $mbid)
    {
        $this->assertEquals($validation, $this->brainz->isValidMBID($mbid));
    }
}

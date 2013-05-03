<?php

namespace MusicBrainz\Tests;

use MusicBrainz\MusicBrainz;

/**
 * @covers MusicBrainz\MusicBrainz
 */
class MusicBrainzTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->brainz = new MusicBrainz($this->getMock('\Guzzle\Http\ClientInterface'));
    }

    public function MBIDProvider()
    {
        return array(
            array(true, '4dbf5678-7a31-406a-abbe-232f8ac2cd63')
          , array(true, '4dbf5678-7a31-406a-abbe-232f8ac2cd63')
          , array(false, '4dbf5678-7a314-06aabb-e232f-8ac2cd63') // invalid spacing for UUID's
          , array(false, '4dbf5678-7a31-406a-abbe-232f8az2cd63') // z is an invalid character
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

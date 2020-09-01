<?php

namespace MusicBrainz\Tests;

use GuzzleHttp\ClientInterface;
use MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use MusicBrainz\MusicBrainz;
use PHPUnit\Framework\TestCase;

/**
 * @covers MusicBrainz\MusicBrainz
 */
class MusicBrainzTest extends TestCase
{
    /**
     * @var \MusicBrainz\MusicBrainz
     */
    protected $brainz;

    public function setUp(): void
    {
        /** @noinspection PhpParamsInspection */
        $this->brainz = new MusicBrainz(
            new GuzzleHttpAdapter(
                $this->getMockBuilder(ClientInterface::class)->getMock()
            )
        );
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

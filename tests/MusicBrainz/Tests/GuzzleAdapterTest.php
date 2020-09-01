<?php

namespace MusicBrainz\Tests;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use MusicBrainz\MusicBrainz;
use PHPUnit\Framework\TestCase;

/**
 * @covers MusicBrainz\HttpAdapters\GuzzleHttpAdapter
 */
class GuzzleAdapterTest extends TestCase
{
    /**
     * @var \MusicBrainz\MusicBrainz
     */
    protected $brainz;

    public function setUp(): void
    {
        $stubClient = $this->createStub(ClientInterface::class);
        $stubClient->method('getConfig')->willReturn([]);
        $stubClient->method('request')
            ->willReturn(new Response(
                200,
                [],
                file_get_contents(__DIR__.'/../../Responses/artist/2c629b8c-d751-4131-b785-5690bb5e0fd7.json')
            ));

        /** @noinspection PhpParamsInspection */
        $this->brainz = new MusicBrainz(
            new GuzzleHttpAdapter(
                $stubClient
            )
        );
    }

    public function testGuzzleAdapter()
    {
        $response = $this->brainz->lookup('artist', '2c629b8c-d751-4131-b785-5690bb5e0fd7');

        $this->assertEquals('2c629b8c-d751-4131-b785-5690bb5e0fd7', $response['id']);
        $this->assertEquals('The Kills', $response['name']);
    }
}

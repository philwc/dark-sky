<?php
declare(strict_types=1);

namespace philwc\DarkSky;

use philwc\DarkSky\Client\ForecastClient;
use philwc\DarkSky\Client\TimeMachineClient;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientFactoryTest
 * @package philwc\DarkSky
 * @covers \philwc\DarkSky\ClientFactory
 * @covers \philwc\DarkSky\Client\Client
 * @covers \philwc\DarkSky\ClientAdapter\GuzzleAdapter
 */
class ClientFactoryTest extends TestCase
{
    /**
     * @throws Exception\InvalidClientException
     */
    public function testGetForecastClient(): void
    {
        $this->assertInstanceOf(
            ForecastClient::class,
            ClientFactory::get(ClientFactory::FORECAST, '')
        );
    }

    /**
     * @throws Exception\InvalidClientException
     */
    public function testGetTimeMachineClient(): void
    {
        $this->assertInstanceOf(
            TimeMachineClient::class,
            ClientFactory::get(ClientFactory::TIME_MACHINE, '')
        );
    }

    /**
     * @expectedException \philwc\DarkSky\Exception\InvalidClientException
     */
    public function testInvalidClient(): void
    {
        ClientFactory::get('', '');
    }
}

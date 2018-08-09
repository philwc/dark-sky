<?php
declare(strict_types=1);

namespace philwc\DarkSky\Client;

use philwc\DarkSky\ClientAdapter\NullClientAdapter;
use philwc\DarkSky\Entity\Weather;
use philwc\DarkSky\Value\Latitude;
use philwc\DarkSky\Value\Longitude;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * Class TimeMachineClientTest
 * @package philwc\DarkSky\Client
 * @covers \philwc\DarkSky\Client\TimeMachineClient
 * @covers \philwc\DarkSky\Client\Client
 * @covers \philwc\DarkSky\Value\Longitude
 * @covers \philwc\DarkSky\Value\Latitude
 * @covers \philwc\DarkSky\DateTimeHelper
 * @covers \philwc\DarkSky\EntityCollection\AlertCollection
 * @covers \philwc\DarkSky\EntityCollection\DailyDataPointCollection
 * @covers \philwc\DarkSky\EntityCollection\EntityCollection
 * @covers \philwc\DarkSky\EntityCollection\HourlyDataPointCollection
 * @covers \philwc\DarkSky\EntityCollection\MinutelyDataPointCollection
 * @covers \philwc\DarkSky\Entity\Alert
 * @covers \philwc\DarkSky\Entity\DataBlock
 * @covers \philwc\DarkSky\Entity\DataPoint
 * @covers \philwc\DarkSky\Entity\DataPoint\CurrentlyDataPoint
 * @covers \philwc\DarkSky\Entity\DataPoint\DailyDataPoint
 * @covers \philwc\DarkSky\Entity\DataPoint\HourlyDataPoint
 * @covers \philwc\DarkSky\Entity\DataPoint\MinutelyDataPoint
 * @covers \philwc\DarkSky\Entity\Entity
 * @covers \philwc\DarkSky\Entity\Flags
 * @covers \philwc\DarkSky\Entity\Weather
 * @covers \philwc\DarkSky\Entity\Weather
 * @covers \philwc\DarkSky\Value\Bearing
 * @covers \philwc\DarkSky\Value\CloudCover
 * @covers \philwc\DarkSky\Value\Humidity
 * @covers \philwc\DarkSky\Value\Icon
 * @covers \philwc\DarkSky\Value\MoonPhase
 * @covers \philwc\DarkSky\Value\PrecipProbability
 * @covers \philwc\DarkSky\Value\PrecipType
 * @covers \philwc\DarkSky\Value\Source
 * @covers \philwc\DarkSky\Value\Visibility
 * @covers \philwc\DarkSky\ClientAdapter\NullClientAdapter
 * @covers \philwc\DarkSky\Entity\Precipitation
 * @covers \philwc\DarkSky\Entity\ApparentTemperature
 * @covers \philwc\DarkSky\Entity\Temperature
 */
class TimeMachineClientTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testRetrieve(): void
    {
        $clientAdapter = new NullClientAdapter(file_get_contents(__DIR__ . '/../data/time-machine.json'));

        $timeMachineClient = new TimeMachineClient($clientAdapter, '');
        $timeMachineClient->setLogger(new NullLogger());
        $weather = $timeMachineClient->retrieve(
            new Latitude(42.3601),
            new Longitude(-71.0589),
            new \DateTimeImmutable()
        );

        $this->assertInstanceOf(Weather::class, $weather);
    }

    /**
     * @throws \Exception
     */
    public function testSimpleRetrieve(): void
    {
        $clientAdapter = new NullClientAdapter(file_get_contents(__DIR__ . '/../data/time-machine.json'));

        $timeMachineClient = new TimeMachineClient($clientAdapter, '');
        $timeMachineClient->setLogger(new NullLogger());
        $weather = $timeMachineClient->simpleRetrieve(42.3601, -71.0589, time());

        $this->assertInstanceOf(Weather::class, $weather);
    }
}

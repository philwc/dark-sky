<?php
declare(strict_types=1);

namespace philwc\DarkSky\Client;

use philwc\DarkSky\ClientAdapter\NullClientAdapter;
use philwc\DarkSky\Entity\Weather;
use philwc\DarkSky\Value\Float\Latitude;
use philwc\DarkSky\Value\Float\Longitude;
use philwc\DarkSky\Value\String\Units;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * Class ForecastClientTest
 * @package philwc\DarkSky\Client
 * @covers \philwc\DarkSky\Client\ForecastClient
 * @covers \philwc\DarkSky\Client\Client
 * @covers \philwc\DarkSky\Value\Float\Longitude
 * @covers \philwc\DarkSky\Value\Float\Latitude
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
 * @covers \philwc\DarkSky\Value\Float\CloudCover
 * @covers \philwc\DarkSky\Value\Float\Humidity
 * @covers \philwc\DarkSky\Value\String\Icon
 * @covers \philwc\DarkSky\Value\Float\MoonPhase
 * @covers \philwc\DarkSky\Value\Float\PrecipProbability
 * @covers \philwc\DarkSky\Value\String\Source
 * @covers \philwc\DarkSky\Value\Float\Visibility
 * @covers \philwc\DarkSky\ClientAdapter\NullClientAdapter
 * @covers \philwc\DarkSky\Entity\ApparentTemperature
 * @covers \philwc\DarkSky\Entity\Precipitation
 * @covers \philwc\DarkSky\Entity\Temperature
 * @covers \philwc\DarkSky\Entity\NearestStorm
 * @covers \philwc\DarkSky\Entity\Wind
 * @covers \philwc\DarkSky\Value\Float\ApparentTemperature
 * @covers \philwc\DarkSky\Value\Float\ApparentTemperatureLow
 * @covers \philwc\DarkSky\Value\Float\ApparentTemperatureHigh
 * @covers \philwc\DarkSky\Value\Float\DewPoint
 * @covers \philwc\DarkSky\Value\Float\FloatValue
 * @covers \philwc\DarkSky\Value\Float\NearestStation
 * @covers \philwc\DarkSky\Value\Float\Ozone
 * @covers \philwc\DarkSky\Value\Float\PrecipIntensity
 * @covers \philwc\DarkSky\Value\Float\PrecipIntensityError
 * @covers \philwc\DarkSky\Value\Float\Pressure
 * @covers \philwc\DarkSky\Value\Float\Temperature
 * @covers \philwc\DarkSky\Value\Float\TemperatureLow
 * @covers \philwc\DarkSky\Value\Float\TemperatureHigh
 * @covers \philwc\DarkSky\Value\Float\PrecipIntensityMax
 * @covers \philwc\DarkSky\Value\Float\WindGust
 * @covers \philwc\DarkSky\Value\Float\WindSpeed
 * @covers \philwc\DarkSky\Value\Int\IntValue
 * @covers \philwc\DarkSky\Value\Int\NearestStormBearing
 * @covers \philwc\DarkSky\Value\Int\NearestStormDistance
 * @covers \philwc\DarkSky\Value\Int\UvIndex
 * @covers \philwc\DarkSky\Value\Int\WindBearing
 * @covers \philwc\DarkSky\Value\String\PrecipType
 * @covers \philwc\DarkSky\Value\String\StringValue
 * @covers \philwc\DarkSky\Value\String\Units
 * @covers \philwc\DarkSky\Value\OptionalParameters
 * @covers \philwc\DarkSky\Value\String\Lang
 * @covers \philwc\DarkSky\Value\Value
 */
class ForecastClientTest extends TestCase
{
    /**
     * @throws \Assert\AssertionFailedException
     */
    public function testRetrieve(): void
    {
        $clientAdapter = new NullClientAdapter(file_get_contents(__DIR__ . '/../data/forecast.json'));

        $forecastClient = new ForecastClient($clientAdapter, '');
        $forecastClient->setLogger(new NullLogger());

        $weather = $forecastClient->retrieve(new Latitude(42.3601), new Longitude(-71.0589));

        $this->assertInstanceOf(Weather::class, $weather);
    }

    public function testSimpleRetrieve(): void
    {
        $clientAdapter = new NullClientAdapter(file_get_contents(__DIR__ . '/../data/forecast.json'));

        $forecastClient = new ForecastClient($clientAdapter, '');
        $forecastClient->setLogger(new NullLogger());
        $weather = $forecastClient->simpleRetrieve(42.3601, -71.0589);

        $this->assertInstanceOf(Weather::class, $weather);
    }
}

<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use Assert\AssertionFailedException;
use philwc\DarkSky\Entity\DataPoint\CurrentlyDataPoint;
use philwc\DarkSky\Entity\DataPoint\DailyDataPoint;
use philwc\DarkSky\Entity\DataPoint\HourlyDataPoint;
use philwc\DarkSky\Entity\DataPoint\MinutelyDataPoint;
use philwc\DarkSky\Exception\MissingDataException;
use PHPUnit\Framework\TestCase;

/**
 * Class WeatherTest
 * @package philwc\DarkSky\Entity
 * @covers \philwc\DarkSky\Entity\Weather
 * @covers \philwc\DarkSky\Entity\Alert
 * @covers \philwc\DarkSky\Entity\DataBlock
 * @covers \philwc\DarkSky\Entity\Flags
 * @covers \philwc\DarkSky\Entity\DataPoint\CurrentlyDataPoint
 * @covers \philwc\DarkSky\Entity\DataPoint\DailyDataPoint
 * @covers \philwc\DarkSky\Entity\DataPoint\HourlyDataPoint
 * @covers \philwc\DarkSky\Entity\DataPoint\MinutelyDataPoint
 * @covers \philwc\DarkSky\DateTimeHelper
 * @covers \philwc\DarkSky\EntityCollection\AlertCollection
 * @covers \philwc\DarkSky\EntityCollection\DailyDataPointCollection
 * @covers \philwc\DarkSky\EntityCollection\EntityCollection
 * @covers \philwc\DarkSky\EntityCollection\HourlyDataPointCollection
 * @covers \philwc\DarkSky\EntityCollection\MinutelyDataPointCollection
 * @covers \philwc\DarkSky\Entity\DataPoint
 * @covers \philwc\DarkSky\Value\Float\CloudCover
 * @covers \philwc\DarkSky\Value\Float\Humidity
 * @covers \philwc\DarkSky\Value\String\Icon
 * @covers \philwc\DarkSky\Value\Float\Latitude
 * @covers \philwc\DarkSky\Value\Float\Longitude
 * @covers \philwc\DarkSky\Value\Float\MoonPhase
 * @covers \philwc\DarkSky\Value\Float\PrecipProbability
 * @covers \philwc\DarkSky\Entity\Entity
 * @covers \philwc\DarkSky\Value\String\PrecipType
 * @covers \philwc\DarkSky\Value\String\Source
 * @covers \philwc\DarkSky\Value\Float\Visibility
 * @covers \philwc\DarkSky\Exception\MissingDataException
 * @covers \philwc\DarkSky\Entity\Temperature
 * @covers \philwc\DarkSky\Entity\ApparentTemperature
 * @covers \philwc\DarkSky\Entity\Precipitation
 * @covers \philwc\DarkSky\Entity\NearestStorm
 * @covers \philwc\DarkSky\Entity\Wind
 * @covers \philwc\DarkSky\Entity\ApparentTemperature
 * @covers \philwc\DarkSky\Value\Float\DewPoint
 * @covers \philwc\DarkSky\Value\Float\NearestStation
 * @covers \philwc\DarkSky\Value\Float\Ozone
 * @covers \philwc\DarkSky\Value\Float\PrecipIntensity
 * @covers \philwc\DarkSky\Value\Float\ApparentTemperature
 * @covers \philwc\DarkSky\Value\Float\FloatValue
 * @covers \philwc\DarkSky\Value\Float\PrecipIntensityError
 * @covers \philwc\DarkSky\Value\Float\PrecipIntensityMax
 * @covers \philwc\DarkSky\Value\Float\Temperature
 * @covers \philwc\DarkSky\Value\Float\TemperatureHigh
 * @covers \philwc\DarkSky\Value\Float\TemperatureLow
 * @covers \philwc\DarkSky\Value\Float\WindGust
 * @covers \philwc\DarkSky\Value\Float\WindSpeed
 * @covers \philwc\DarkSky\Value\Float\ApparentTemperatureHigh
 * @covers \philwc\DarkSky\Value\Float\ApparentTemperatureLow
 * @covers \philwc\DarkSky\Value\Float\Pressure
 * @covers \philwc\DarkSky\Value\Int\IntValue
 * @covers \philwc\DarkSky\Value\Int\NearestStormBearing
 * @covers \philwc\DarkSky\Value\Int\NearestStormDistance
 * @covers \philwc\DarkSky\Value\Int\UvIndex
 * @covers \philwc\DarkSky\Value\Int\WindBearing
 * @covers \philwc\DarkSky\Value\String\StringValue
 * @covers \philwc\DarkSky\Value\String\Units
 * @covers \philwc\DarkSky\Value\Value
 *
 */
class WeatherTest extends TestCase
{

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        $exampleDataPath = __DIR__ . '/../data';
        $paths = [
            $exampleDataPath . '/forecast.json',
        ];

        $datasets = [];
        foreach ($paths as $path) {
            $datasets[] = json_decode(
                file_get_contents($path),
                true
            );
        }

        return [$datasets];
    }

    public function testInvalidWeather(): void
    {
        try {
            Weather::fromArray(['testKey' => 'testValue']);
        } catch (MissingDataException $e) {
            $this->assertInstanceOf(MissingDataException::class, $e);
            $this->assertEquals(['testKey'], $e->getAvailableFields());
        } catch (AssertionFailedException $e) {
        } catch (\Exception $e) {
        }
    }

    /**
     * @param array $data
     * @throws MissingDataException
     * @throws \Assert\AssertionFailedException
     * @dataProvider dataProvider
     */
    public function testWeather(array $data): void
    {
        $weather = Weather::fromArray($data);
        $this->assertEquals(
            $data['latitude'],
            $weather->getLatitude()->toFloat()
        );
        $this->assertEquals(
            $data['longitude'],
            $weather->getLongitude()->toFloat()
        );
        $this->assertEquals(
            $data['timezone'],
            $weather->getTimezone()->getName()
        );

        $this->hourlyTest($weather, $data);
        $this->minutelyTest($weather, $data);
        $this->currentlyTest($weather, $data);
        $this->dailyTest($weather, $data);
        $this->alertsTest($weather, $data);
        $this->flagsTest($weather, $data);
    }

    /**
     * @param Weather $weather
     * @param array $forecastData
     */
    private function hourlyTest(Weather $weather, array $forecastData): void
    {
        $hourly = $weather->getHourly();
        $testData = $forecastData['hourly'];
        $this->assertEquals(
            $testData['icon'],
            $hourly->getIcon()->getValue()
        );
        $this->assertEquals(
            $testData['summary'],
            $hourly->getSummary()->toString()
        );

        /** @var HourlyDataPoint $data */
        $data = $hourly->getData()->first();
        $firstTestData = $testData['data'][0];

        $this->assertEquals(
            $firstTestData['time'],
            $data->getTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['summary'],
            $data->getSummary()->toString()
        );
        $this->assertEquals(
            $firstTestData['icon'],
            $data->getIcon()->getValue()
        );
        $this->assertEquals(
            $firstTestData['precipIntensity'],
            $data->getPrecipitation()->getIntensity()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['precipProbability'],
            $data->getPrecipitation()->getProbability()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['precipType'],
            $data->getPrecipitation()->getType()->toString()
        );
        $this->assertEquals(
            $firstTestData['temperature'],
            $data->getTemperature()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['apparentTemperature'],
            $data->getApparentTemperature()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['dewPoint'],
            $data->getDewPoint()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['humidity'],
            $data->getHumidity()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['pressure'],
            $data->getPressure()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['windSpeed'],
            $data->getWind()->getSpeed()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['windGust'],
            $data->getWind()->getGust()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['windBearing'],
            $data->getWind()->getBearing()->toInt()
        );
        $this->assertEquals(
            $firstTestData['cloudCover'] * 100,
            $data->getCloudCover()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['uvIndex'],
            $data->getUvIndex()->toInt()
        );
        $this->assertEquals(
            $firstTestData['visibility'],
            $data->getVisibility()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['ozone'],
            $data->getOzone()->toFloat()
        );
    }

    /**
     * @param Weather $weather
     * @param array $forecastData
     */
    private function minutelyTest(Weather $weather, array $forecastData): void
    {
        $minutely = $weather->getMinutely();
        $testData = $forecastData['minutely'];
        $this->assertEquals(
            $testData['icon'],
            $minutely->getIcon()->getValue()
        );
        $this->assertEquals(
            $testData['summary'],
            $minutely->getSummary()->toString()
        );

        /** @var MinutelyDataPoint $data */
        $data = $minutely->getData()->first();
        $firstTestData = $testData['data'][0];

        $this->assertEquals(
            $firstTestData['time'],
            $data->getTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['precipIntensity'],
            $data->getPrecipitation()->getIntensity()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['precipProbability'],
            $data->getPrecipitation()->getProbability()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['precipType'],
            $data->getPrecipitation()->getType()->toString()
        );
    }

    /**
     * @param Weather $weather
     * @param array $forecastData
     */
    private function currentlyTest(Weather $weather, array $forecastData): void
    {
        /** @var CurrentlyDataPoint $currently */
        $currently = $weather->getCurrently();
        $testData = $forecastData['currently'];
        $this->assertEquals(
            $testData['icon'],
            $currently->getIcon()->getValue()
        );
        $this->assertEquals(
            $testData['summary'],
            $currently->getSummary()->toString()
        );
        $this->assertEquals(
            $testData['time'],
            $currently->getTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $testData['summary'],
            $currently->getSummary()->toString()
        );
        $this->assertEquals(
            $testData['icon'],
            $currently->getIcon()->getValue()
        );
        $this->assertEquals(
            $testData['precipIntensity'],
            $currently->getPrecipitation()->getIntensity()->toFloat()
        );
        $this->assertEquals(
            $testData['precipIntensityError'],
            $currently->getPrecipitation()->getIntensityError()->toFloat()
        );
        $this->assertEquals(
            $testData['precipProbability'],
            $currently->getPrecipitation()->getProbability()->toFloat()
        );
        $this->assertEquals(
            $testData['precipType'],
            $currently->getPrecipitation()->getType()->toString()
        );
        $this->assertEquals(
            $testData['temperature'],
            $currently->getTemperature()->toFloat()
        );
        $this->assertEquals(
            $testData['apparentTemperature'],
            $currently->getApparentTemperature()->toFloat()
        );
        $this->assertEquals(
            $testData['dewPoint'],
            $currently->getDewPoint()->toFloat()
        );
        $this->assertEquals(
            $testData['humidity'],
            $currently->getHumidity()->toFloat()
        );
        $this->assertEquals(
            $testData['pressure'],
            $currently->getPressure()->toFloat()
        );
        $this->assertEquals(
            $testData['windSpeed'],
            $currently->getWind()->getSpeed()->toFloat()
        );
        $this->assertEquals(
            $testData['windGust'],
            $currently->getWind()->getGust()->toFloat()
        );
        $this->assertEquals(
            $testData['windBearing'],
            $currently->getWind()->getBearing()->toInt()
        );
        $this->assertEquals(
            $testData['cloudCover'] * 100,
            $currently->getCloudCover()->toFloat()
        );
        $this->assertEquals(
            $testData['uvIndex'],
            $currently->getUvIndex()->toInt()
        );
        $this->assertEquals(
            $testData['visibility'],
            $currently->getVisibility()->toFloat()
        );
        $this->assertEquals(
            $testData['ozone'],
            $currently->getOzone()->toFloat()
        );
        $this->assertEquals(
            $testData['nearestStormBearing'],
            $currently->getNearestStorm()->getBearing()->toInt()
        );
        $this->assertEquals(
            $testData['nearestStormDistance'],
            $currently->getNearestStorm()->getDistance()->toInt()
        );
    }

    /**
     * @param Weather $weather
     * @param array $forecastData
     */
    private function dailyTest(Weather $weather, array $forecastData): void
    {
        $daily = $weather->getDaily();
        $testData = $forecastData['daily'];
        $this->assertEquals(
            $testData['icon'],
            $daily->getIcon()->getValue()
        );
        $this->assertEquals(
            $testData['summary'],
            $daily->getSummary()->toString()
        );

        /** @var DailyDataPoint $data */
        $data = $daily->getData()->first();
        $firstTestData = $testData['data'][0];

        $this->assertEquals(
            $firstTestData['time'],
            $data->getTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['summary'],
            $data->getSummary()->toString()
        );
        $this->assertEquals(
            $firstTestData['icon'],
            $data->getIcon()->getValue()
        );
        $this->assertEquals(
            $firstTestData['sunriseTime'],
            $data->getSunriseTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['sunsetTime'],
            $data->getSunsetTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['moonPhase'],
            $data->getMoonPhase()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['precipIntensity'],
            $data->getPrecipitation()->getIntensity()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['precipIntensityMax'],
            $data->getPrecipIntensityMax()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['precipIntensityMaxTime'],
            $data->getPrecipIntensityMaxTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['precipProbability'],
            $data->getPrecipitation()->getProbability()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['precipType'],
            $data->getPrecipitation()->getType()->toString()
        );
        $this->assertEquals(
            $firstTestData['temperatureHigh'],
            $data->getTemperature()->getHigh()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['temperatureHighTime'],
            $data->getTemperature()->getHighTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['temperatureLow'],
            $data->getTemperature()->getLow()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['temperatureLowTime'],
            $data->getTemperature()->getLowTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['apparentTemperatureHigh'],
            $data->getApparentTemperature()->getHigh()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['apparentTemperatureHighTime'],
            $data->getApparentTemperature()->getHighTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['apparentTemperatureLow'],
            $data->getApparentTemperature()->getLow()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['apparentTemperatureLowTime'],
            $data->getApparentTemperature()->getLowTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['dewPoint'],
            $data->getDewPoint()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['humidity'],
            $data->getHumidity()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['pressure'],
            $data->getPressure()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['windSpeed'],
            $data->getWind()->getSpeed()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['windGust'],
            $data->getWind()->getGust()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['windGustTime'],
            $data->getWindGustTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['windBearing'],
            $data->getWind()->getBearing()->toInt()
        );
        $this->assertEquals(
            $firstTestData['cloudCover'] * 100,
            $data->getCloudCover()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['uvIndex'],
            $data->getUvIndex()->toInt()
        );
        $this->assertEquals(
            $firstTestData['uvIndexTime'],
            $data->getUvIndexTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $firstTestData['visibility'],
            $data->getVisibility()->toFloat()
        );
        $this->assertEquals(
            $firstTestData['ozone'],
            $data->getOzone()->toFloat()
        );
    }

    /**
     * @param Weather $weather
     * @param array $forecastData
     */
    private function alertsTest(Weather $weather, array $forecastData): void
    {
        $alerts = $weather->getAlerts();
        $alert = $alerts->first();
        $testData = $forecastData['alerts'][0];

        $this->assertEquals(
            $testData['title'],
            $alert->getTitle()
        );
        $this->assertEquals(
            $testData['regions'],
            $alert->getRegions()
        );
        $this->assertEquals(
            $testData['severity'],
            $alert->getSeverity()
        );
        $this->assertEquals(
            $testData['time'],
            $alert->getTime()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $testData['expires'],
            $alert->getExpires()->toDateTimeImmutable()->format('U')
        );
        $this->assertEquals(
            $testData['description'],
            $alert->getDescription()
        );
        $this->assertEquals(
            $testData['uri'],
            $alert->getUri()
        );
    }

    /**
     * @param Weather $weather
     * @param array $forecastData
     */
    private function flagsTest(Weather $weather, array $forecastData): void
    {
        $flags = $weather->getFlags();
        $testData = $forecastData['flags'];

        foreach ($flags->getSources() as $index => $source) {
            $this->assertEquals(
                $testData['sources'][$index],
                $source->toString()
            );
        }

        $this->assertEquals(
            $testData['nearest-station'],
            $flags->getNearestStation()->toFloat()
        );
        $this->assertEquals(
            $testData['units'],
            $flags->getUnits()->toString()
        );
    }
}

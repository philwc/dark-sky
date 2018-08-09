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
 * @covers \philwc\DarkSky\Value\Bearing
 * @covers \philwc\DarkSky\Value\CloudCover
 * @covers \philwc\DarkSky\Value\Humidity
 * @covers \philwc\DarkSky\Value\Icon
 * @covers \philwc\DarkSky\Value\Latitude
 * @covers \philwc\DarkSky\Value\Longitude
 * @covers \philwc\DarkSky\Value\MoonPhase
 * @covers \philwc\DarkSky\Value\PrecipProbability
 * @covers \philwc\DarkSky\Entity\Entity
 * @covers \philwc\DarkSky\Value\PrecipType
 * @covers \philwc\DarkSky\Value\Source
 * @covers \philwc\DarkSky\Value\Visibility
 * @covers \philwc\DarkSky\Exception\MissingDataException
 * @covers \philwc\DarkSky\Entity\Temperature
 * @covers \philwc\DarkSky\Entity\ApparentTemperature
 * @covers \philwc\DarkSky\Entity\Precipitation
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
        $this->assertEquals($data['latitude'], $weather->getLatitude());
        $this->assertEquals($data['longitude'], $weather->getLongitude());
        $this->assertEquals($data['timezone'], $weather->getTimezone()->getName());

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
        $this->assertEquals($testData['icon'], $hourly->getIcon());
        $this->assertEquals($testData['summary'], $hourly->getSummary());

        /** @var HourlyDataPoint $data */
        $data = $hourly->getData()->first();
        $firstTestData = $testData['data'][0];

        $this->assertEquals($firstTestData['time'], $data->getTime()->format('U'));
        $this->assertEquals($firstTestData['summary'], $data->getSummary());
        $this->assertEquals($firstTestData['icon'], $data->getIcon());
        $this->assertEquals($firstTestData['precipIntensity'], $data->getPrecipitation()->getIntensity());
        $this->assertEquals($firstTestData['precipProbability'], $data->getPrecipitation()->getProbability());
        $this->assertEquals($firstTestData['precipType'], $data->getPrecipitation()->getType());
        $this->assertEquals($firstTestData['temperature'], $data->getTemperature());
        $this->assertEquals($firstTestData['apparentTemperature'], $data->getApparentTemperature());
        $this->assertEquals($firstTestData['dewPoint'], $data->getDewPoint());
        $this->assertEquals($firstTestData['humidity'], $data->getHumidity());
        $this->assertEquals($firstTestData['pressure'], $data->getPressure());
        $this->assertEquals($firstTestData['windSpeed'], $data->getWindSpeed());
        $this->assertEquals($firstTestData['windGust'], $data->getWindGust());
        $this->assertEquals($firstTestData['windBearing'], $data->getWindBearing());
        $this->assertEquals($firstTestData['cloudCover'], $data->getCloudCover());
        $this->assertEquals($firstTestData['uvIndex'], $data->getUvIndex());
        $this->assertEquals($firstTestData['visibility'], $data->getVisibility());
        $this->assertEquals($firstTestData['ozone'], $data->getOzone());
    }

    /**
     * @param Weather $weather
     * @param array $forecastData
     */
    private function minutelyTest(Weather $weather, array $forecastData): void
    {
        $minutely = $weather->getMinutely();
        $testData = $forecastData['minutely'];
        $this->assertEquals($testData['icon'], $minutely->getIcon());
        $this->assertEquals($testData['summary'], $minutely->getSummary());

        /** @var MinutelyDataPoint $data */
        $data = $minutely->getData()->first();
        $firstTestData = $testData['data'][0];

        $this->assertEquals($firstTestData['time'], $data->getTime()->format('U'));
        $this->assertEquals($firstTestData['precipIntensity'], $data->getPrecipitation()->getIntensity());
        $this->assertEquals(
            $firstTestData['precipProbability'],
            $data->getPrecipitation()->getProbability()
        );
        $this->assertEquals($firstTestData['precipType'], $data->getPrecipitation()->getType());
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
        $this->assertEquals($testData['icon'], $currently->getIcon());
        $this->assertEquals($testData['summary'], $currently->getSummary());

        $this->assertEquals($testData['time'], $currently->getTime()->format('U'));
        $this->assertEquals($testData['summary'], $currently->getSummary());
        $this->assertEquals($testData['icon'], $currently->getIcon());
        $this->assertEquals($testData['precipIntensity'], $currently->getPrecipitation()->getIntensity());
        $this->assertEquals($testData['precipIntensityError'], $currently->getPrecipitation()->getIntensityError());
        $this->assertEquals($testData['precipProbability'], $currently->getPrecipitation()->getProbability());
        $this->assertEquals($testData['precipType'], $currently->getPrecipitation()->getType());
        $this->assertEquals($testData['temperature'], $currently->getTemperature());
        $this->assertEquals($testData['apparentTemperature'], $currently->getApparentTemperature());
        $this->assertEquals($testData['dewPoint'], $currently->getDewPoint());
        $this->assertEquals($testData['humidity'], $currently->getHumidity());
        $this->assertEquals($testData['pressure'], $currently->getPressure());
        $this->assertEquals($testData['windSpeed'], $currently->getWindSpeed());
        $this->assertEquals($testData['windGust'], $currently->getWindGust());
        $this->assertEquals($testData['windBearing'], $currently->getWindBearing());
        $this->assertEquals($testData['cloudCover'], $currently->getCloudCover());
        $this->assertEquals($testData['uvIndex'], $currently->getUvIndex());
        $this->assertEquals($testData['visibility'], $currently->getVisibility());
        $this->assertEquals($testData['ozone'], $currently->getOzone());
        $this->assertEquals($testData['nearestStormBearing'], $currently->getNearestStormBearing());
        $this->assertEquals($testData['nearestStormDistance'], $currently->getNearestStormDistance());
    }

    /**
     * @param Weather $weather
     * @param array $forecastData
     */
    private function dailyTest(Weather $weather, array $forecastData): void
    {
        $daily = $weather->getDaily();
        $testData = $forecastData['daily'];
        $this->assertEquals($testData['icon'], $daily->getIcon());
        $this->assertEquals($testData['summary'], $daily->getSummary());

        /** @var DailyDataPoint $data */
        $data = $daily->getData()->first();
        $firstTestData = $testData['data'][0];

        $this->assertEquals($firstTestData['time'], $data->getTime()->format('U'));
        $this->assertEquals($firstTestData['summary'], $data->getSummary());
        $this->assertEquals($firstTestData['icon'], $data->getIcon());
        $this->assertEquals($firstTestData['sunriseTime'], $data->getSunriseTime()->format('U'));
        $this->assertEquals($firstTestData['sunsetTime'], $data->getSunsetTime()->format('U'));
        $this->assertEquals($firstTestData['moonPhase'], $data->getMoonPhase());
        $this->assertEquals($firstTestData['precipIntensity'], $data->getPrecipitation()->getIntensity());
        $this->assertEquals($firstTestData['precipIntensityMax'], $data->getPrecipIntensityMax());
        $this->assertEquals($firstTestData['precipIntensityMaxTime'], $data->getPrecipIntensityMaxTime()->format('U'));
        $this->assertEquals($firstTestData['precipProbability'], $data->getPrecipitation()->getProbability());
        $this->assertEquals($firstTestData['precipType'], $data->getPrecipitation()->getType());
        $this->assertEquals($firstTestData['temperatureHigh'], $data->getTemperature()->getHigh());
        $this->assertEquals($firstTestData['temperatureHighTime'], $data->getTemperature()->getHighTime()->format('U'));
        $this->assertEquals($firstTestData['temperatureLow'], $data->getTemperature()->getLow());
        $this->assertEquals($firstTestData['temperatureLowTime'], $data->getTemperature()->getLowTime()->format('U'));
        $this->assertEquals($firstTestData['apparentTemperatureHigh'], $data->getApparentTemperature()->getHigh());
        $this->assertEquals(
            $firstTestData['apparentTemperatureHighTime'],
            $data->getApparentTemperature()->getHighTime()->format('U')
        );
        $this->assertEquals(
            $firstTestData['apparentTemperatureLow'],
            $data->getApparentTemperature()->getLow()
        );
        $this->assertEquals(
            $firstTestData['apparentTemperatureLowTime'],
            $data->getApparentTemperature()->getLowTime()->format('U')
        );
        $this->assertEquals($firstTestData['dewPoint'], $data->getDewPoint());
        $this->assertEquals($firstTestData['humidity'], $data->getHumidity());
        $this->assertEquals($firstTestData['pressure'], $data->getPressure());
        $this->assertEquals($firstTestData['windSpeed'], $data->getWindSpeed());
        $this->assertEquals($firstTestData['windGust'], $data->getWindGust());
        $this->assertEquals($firstTestData['windGustTime'], $data->getWindGustTime()->format('U'));
        $this->assertEquals($firstTestData['windBearing'], $data->getWindBearing());
        $this->assertEquals($firstTestData['cloudCover'], $data->getCloudCover());
        $this->assertEquals($firstTestData['uvIndex'], $data->getUvIndex());
        $this->assertEquals($firstTestData['uvIndexTime'], $data->getUvIndexTime()->format('U'));
        $this->assertEquals($firstTestData['visibility'], $data->getVisibility());
        $this->assertEquals($firstTestData['ozone'], $data->getOzone());
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

        $this->assertEquals($testData['title'], $alert->getTitle());
        $this->assertEquals($testData['regions'], $alert->getRegions());
        $this->assertEquals($testData['severity'], $alert->getSeverity());
        $this->assertEquals($testData['time'], $alert->getTime()->format('U'));
        $this->assertEquals($testData['expires'], $alert->getExpires()->format('U'));
        $this->assertEquals($testData['description'], $alert->getDescription());
        $this->assertEquals($testData['uri'], $alert->getUri());
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
            $this->assertEquals($testData['sources'][$index], $source->toString());
        }

        $this->assertEquals($testData['nearest-station'], $flags->getNearestStation());
        $this->assertEquals($testData['units'], $flags->getUnits());
    }
}

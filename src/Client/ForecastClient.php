<?php
declare(strict_types=1);

namespace philwc\DarkSky\Client;

use philwc\DarkSky\Entity\Weather;
use philwc\DarkSky\Value\Float\Latitude;
use philwc\DarkSky\Value\Float\Longitude;
use philwc\DarkSky\Value\OptionalParameters;

/**
 * Class ForecastClient
 * @package philwc\DarkSky\Client
 */
class ForecastClient extends Client
{
    private const URI = 'https://api.darksky.net/forecast/%s/%s,%s';

    /**
     * @var int
     */
    private $ttl = 60;

    /**
     * @param int $ttl
     */
    public function setTTL(int $ttl): void
    {
        $this->ttl = $ttl;
    }

    /**
     * @param Latitude $latitude
     * @param Longitude $longitude
     * @param OptionalParameters $optionalParameters
     * @return Weather
     */
    public function retrieve(
        Latitude $latitude,
        Longitude $longitude,
        OptionalParameters $optionalParameters = null
    ): ?Weather
    {
        $url = sprintf(self::URI, $this->secretKey, $latitude->toFloat(), $longitude->toFloat());
        return $this->makeCall($url, $this->ttl, $optionalParameters);
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param array $options
     * @return Weather
     * @throws \Assert\AssertionFailedException
     */
    public function simpleRetrieve(float $latitude, float $longitude, array $options = []): ?Weather
    {
        $optionalParameters = new OptionalParameters($options);

        return $this->retrieve(
            new Latitude($latitude, $optionalParameters->getUnits()),
            new Longitude($longitude, $optionalParameters->getUnits()),
            $optionalParameters
        );
    }
}

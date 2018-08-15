<?php
declare(strict_types=1);

namespace philwc\DarkSky\Client;

use philwc\DarkSky\Entity\Weather;
use philwc\DarkSky\Value\Float\Latitude;
use philwc\DarkSky\Value\Float\Longitude;
use philwc\DarkSky\Value\OptionalParameters;

/**
 * Class TimeMachineClient
 * @package philwc\DarkSky\Client
 */
class TimeMachineClient extends Client
{
    private const URI = 'https://api.darksky.net/forecast/%s/%s,%s,%s';

    /**
     * @var int
     * 24 Hours
     */
    private $ttl = 86400;

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
     * @param \DateTimeInterface $dateTime
     * @param OptionalParameters|null $optionalParameters
     * @return Weather
     */
    public function retrieve(
        Latitude $latitude,
        Longitude $longitude,
        \DateTimeInterface $dateTime,
        OptionalParameters $optionalParameters = null
    ): ?Weather
    {
        return $this->makeCall(
            sprintf(self::URI, $this->secretKey, $latitude->toFloat(), $longitude->toFloat(), $dateTime->format('U')),
            $this->ttl,
            $optionalParameters
        );
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param int $time
     * @param array|null $options
     * @return Weather
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    public function simpleRetrieve(float $latitude, float $longitude, int $time, array $options = []): ?Weather
    {
        $optionalParameters = new OptionalParameters($options);

        return $this->retrieve(
            new Latitude($latitude, $optionalParameters->getUnits()),
            new Longitude($longitude, $optionalParameters->getUnits()),
            new \DateTimeImmutable('@' . $time),
            $optionalParameters
        );
    }
}

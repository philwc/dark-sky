<?php
declare(strict_types=1);

namespace philwc\DarkSky\Client;

use philwc\DarkSky\Entity\Weather;
use philwc\DarkSky\Value\Latitude;
use philwc\DarkSky\Value\Longitude;

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
     * @return Weather
     */
    public function retrieve(Latitude $latitude, Longitude $longitude, \DateTimeInterface $dateTime): ?Weather
    {
        return $this->makeCall(
            sprintf(self::URI, $this->secretKey, $latitude->toFloat(), $longitude->toFloat(), $dateTime->format('U')),
            $this->ttl
        );
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param int $time
     * @return Weather
     * @throws \Exception
     */
    public function simpleRetrieve(float $latitude, float $longitude, int $time): ?Weather
    {
        return $this->retrieve(new Latitude($latitude), new Longitude($longitude), new \DateTimeImmutable('@' . $time));
    }
}

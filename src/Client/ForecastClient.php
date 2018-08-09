<?php
declare(strict_types=1);

namespace philwc\DarkSky\Client;

use philwc\DarkSky\Entity\Weather;
use philwc\DarkSky\Value\Latitude;
use philwc\DarkSky\Value\Longitude;

/**
 * Class ForecastClient
 * @package philwc\DarkSky\Client
 */
class ForecastClient extends Client
{
    private const URI = 'https://api.darksky.net/forecast/%s/%s,%s';

    /**
     * @param Latitude $latitude
     * @param Longitude $longitude
     * @return Weather
     */
    public function retrieve(Latitude $latitude, Longitude $longitude): ?Weather
    {
        return $this->makeCall(
            sprintf(self::URI, $this->secretKey, $latitude->toFloat(), $longitude->toFloat())
        );
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @return Weather
     */
    public function simpleRetrieve(float $latitude, float $longitude): ?Weather
    {
        return $this->retrieve(new Latitude($latitude), new Longitude($longitude));
    }
}

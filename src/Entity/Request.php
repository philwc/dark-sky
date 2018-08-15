<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Value\Float\Latitude;
use philwc\DarkSky\Value\Float\Longitude;
use philwc\DarkSky\Value\OptionalParameters;

/**
 * Class Request
 * @package philwc\DarkSky\Entity
 */
abstract class Request extends Entity
{
    /**
     * @var Latitude
     */
    protected $latitude;

    /**
     * @var Longitude
     */
    protected $longitude;

    /**
     * @var OptionalParameters
     */
    protected $optionalParameters;

    /**
     * @var string
     */
    protected $locationDescription = '';

    /**
     * @return Latitude
     */
    public function getLatitude(): Latitude
    {
        return $this->latitude;
    }

    /**
     * @return Longitude
     */
    public function getLongitude(): Longitude
    {
        return $this->longitude;
    }

    /**
     * @return OptionalParameters
     */
    public function getOptionalParameters(): OptionalParameters
    {
        return $this->optionalParameters;
    }

    /**
     * @return string
     */
    public function getLocationDescription(): string
    {
        return $this->locationDescription;
    }

    /**
     * @param string $secretKey
     * @return string
     */
    abstract public function getUri(string $secretKey): string;
}

<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Value\Float\WindSpeed;
use philwc\DarkSky\Value\Float\WindGust;
use philwc\DarkSky\Value\Int\WindBearing;

/**
 * Class Wind
 * @package philwc\DarkSky\Entity
 */
class Wind extends Entity
{
    /**
     * @var WindBearing
     */
    private $windBearing;

    /**
     * @var WindGust
     */
    private $windGust;

    /**
     * @var WindSpeed
     */
    private $windSpeed;

    /**
     * @param array $data
     * @return Wind
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): self
    {
        $self = new self();

        if (array_key_exists('windBearing', $data)) {
            $self->windBearing = new WindBearing($data['windBearing'], $data['units']);
        }

        if (array_key_exists('windGust', $data)) {
            $self->windGust = new WindGust($data['windGust'], $data['units']);
        }

        if (array_key_exists('windSpeed', $data)) {
            $self->windSpeed = new WindSpeed($data['windSpeed'], $data['units']);
        }

        return $self;
    }

    /**
     * @return WindBearing
     */
    public function getBearing(): ?WindBearing
    {
        return $this->windBearing;
    }

    /**
     * @return WindGust
     */
    public function getGust(): ?WindGust
    {
        return $this->windGust;
    }

    /**
     * @return WindSpeed
     */
    public function getSpeed(): ?WindSpeed
    {
        return $this->windSpeed;
    }
}

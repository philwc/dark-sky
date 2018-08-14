<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Value\Bearing;

/**
 * Class Wind
 * @package philwc\DarkSky\Entity
 */
class Wind extends Entity
{
    /**
     * @var Bearing
     */
    private $windBearing;

    /**
     * @var float
     */
    private $windGust;

    /**
     * @var float
     */
    private $windSpeed;

    /**
     * @param array $data
     * @return mixed
     */
    public static function fromArray(array $data)
    {
        $self = new self();

        if (array_key_exists('windBearing', $data)) {
            $self->windBearing = new Bearing($data['windBearing']);
        }

        if (array_key_exists('windGust', $data)) {
            $self->windGust = (float)$data['windGust'];
        }

        if (array_key_exists('windSpeed', $data)) {
            $self->windSpeed = (float)$data['windSpeed'];
        }

        return $self;
    }

    /**
     * @return int
     */
    public function getWindBearing(): ?int
    {
        if ($this->windBearing) {
            return $this->windBearing->toInt();
        }
        return null;
    }

    /**
     * @return float
     */
    public function getWindGust(): ?float
    {
        return $this->windGust;
    }

    /**
     * @return float
     */
    public function getWindSpeed(): ?float
    {
        return $this->windSpeed;
    }
}

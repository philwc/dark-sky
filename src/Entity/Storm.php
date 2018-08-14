<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Value\Bearing;

/**
 * Class Storm
 * @package philwc\DarkSky\Entity
 */
class Storm extends Entity
{
    /**
     * @var Bearing
     */
    private $nearestStormBearing;

    /**
     * @var int
     */
    private $nearestStormDistance;

    /**
     * @param array $data
     * @return Storm
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        if (array_key_exists('nearestStormBearing', $data)) {
            $self->nearestStormBearing = new Bearing($data['nearestStormBearing']);
        }

        if (array_key_exists('nearestStormDistance', $data)) {
            $self->nearestStormDistance = (int)$data['nearestStormDistance'];
        }

        return $self;
    }

    /**
     * @return int
     */
    public function getNearestStormBearing(): ?int
    {
        return $this->nearestStormBearing->toInt();
    }

    /**
     * @return int
     */
    public function getNearestStormDistance(): ?int
    {
        return $this->nearestStormDistance;
    }
}

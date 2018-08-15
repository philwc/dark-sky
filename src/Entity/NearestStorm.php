<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Value\Int\NearestStormBearing;
use philwc\DarkSky\Value\Int\NearestStormDistance;

/**
 * Class Storm
 * @package philwc\DarkSky\Entity
 */
class NearestStorm extends Entity
{
    /**
     * @var NearestStormBearing
     */
    private $nearestStormBearing;

    /**
     * @var NearestStormDistance
     */
    private $nearestStormDistance;

    /**
     * @param array $data
     * @return NearestStorm
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        if (array_key_exists('nearestStormBearing', $data)) {
            $self->nearestStormBearing = new NearestStormBearing($data['nearestStormBearing'], $data['units']);
        }

        if (array_key_exists('nearestStormDistance', $data)) {
            $self->nearestStormDistance = new NearestStormDistance($data['nearestStormDistance'], $data['units']);
        }

        return $self;
    }

    /**
     * @return NearestStormBearing
     */
    public function getBearing(): ?NearestStormBearing
    {
        return $this->nearestStormBearing;
    }

    /**
     * @return NearestStormDistance
     */
    public function getDistance(): ?NearestStormDistance
    {
        return $this->nearestStormDistance;
    }
}

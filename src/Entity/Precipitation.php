<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Value\Float\PrecipIntensity;
use philwc\DarkSky\Value\Float\PrecipIntensityError;
use philwc\DarkSky\Value\Float\PrecipProbability;
use philwc\DarkSky\Value\String\PrecipType;

/**
 * Class Precipitation
 * @package philwc\DarkSky\Entity
 */
class Precipitation extends Entity
{
    /**
     * @var PrecipIntensity
     */
    private $precipIntensity;

    /**
     * @var PrecipIntensityError
     */
    private $precipIntensityError;

    /**
     * @var PrecipProbability
     */
    private $precipProbability;

    /**
     * @var PrecipType
     */
    private $precipType;

    /**
     * @param array $data
     * @return mixed
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data)
    {
        $self = new self();

        if (array_key_exists('precipIntensity', $data)) {
            $self->precipIntensity = new PrecipIntensity($data['precipIntensity'], $data['units']);
        }

        if (array_key_exists('precipIntensityError', $data)) {
            $self->precipIntensityError = new PrecipIntensityError($data['precipIntensityError'], $data['units']);
        }

        if (array_key_exists('precipProbability', $data)) {
            $self->precipProbability = new PrecipProbability($data['precipProbability'], $data['units']);
        }

        if (array_key_exists('precipType', $data)) {
            $self->precipType = new PrecipType($data['precipType']);
        }

        return $self;
    }

    /**
     * @return PrecipIntensity
     */
    public function getIntensity(): ?PrecipIntensity
    {
        return $this->precipIntensity;
    }

    /**
     * @return PrecipIntensityError
     */
    public function getIntensityError(): ?PrecipIntensityError
    {
        return $this->precipIntensityError;
    }

    /**
     * @return PrecipProbability
     */
    public function getProbability(): ?PrecipProbability
    {
        return $this->precipProbability;
    }

    /**
     * @return PrecipType
     */
    public function getType(): ?PrecipType
    {
        return $this->precipType;
    }
}

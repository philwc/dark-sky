<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\ClientAdapter\NullClientAdapter;
use philwc\DarkSky\Value\PrecipProbability;
use philwc\DarkSky\Value\PrecipType;

/**
 * Class Precipitation
 * @package philwc\DarkSky\Entity
 */
class Precipitation implements EntityInterface
{
    /**
     * @var float
     */
    private $precipIntensity;

    /**
     * @var float
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
     */
    public static function fromArray(array $data)
    {
        $self = new self();

        if (array_key_exists('precipIntensity', $data)) {
            $self->precipIntensity = (float)$data['precipIntensity'];
        }

        if (array_key_exists('precipIntensityError', $data)) {
            $self->precipIntensityError = (float)$data['precipIntensityError'];
        }

        if (array_key_exists('precipProbability', $data)) {
            $self->precipProbability = new PrecipProbability($data['precipProbability']);
        }

        if (array_key_exists('precipType', $data)) {
            $self->precipType = new PrecipType($data['precipType']);
        }

        return $self;
    }

    /**
     * @return float
     */
    public function getIntensity(): ?float
    {
        return $this->precipIntensity;
    }

    /**
     * @return float
     */
    public function getIntensityError(): ?float
    {
        return $this->precipIntensityError;
    }

    /**
     * @return float
     */
    public function getProbability(): ?float
    {
        if ($this->precipProbability) {
            return $this->precipProbability->toFloat();
        }
        return null;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        if ($this->precipType) {
            return $this->precipType->toString();
        }
        return null;
    }
}

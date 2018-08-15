<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity\DataPoint;

use philwc\DarkSky\Value\Float\ApparentTemperature;
use philwc\DarkSky\Entity\DataPoint;
use philwc\DarkSky\Entity\NearestStorm;
use philwc\DarkSky\Value\Float\Temperature;

/**
 * Class CurrentlyDataPoint
 * @package philwc\DarkSky\Entity\DataPoint
 */
class CurrentlyDataPoint extends DataPoint
{
    /**
     * @var NearestStorm
     */
    private $nearestStorm;

    /**
     * @var ApparentTemperature
     */
    private $apparentTemperature;

    /**
     * @var Temperature
     */
    private $temperature;

    /**
     * @param array $data
     * @return CurrentlyDataPoint
     * @throws \philwc\DarkSky\Exception\InvalidDateFieldException
     * @throws \philwc\DarkSky\Exception\MissingDataException
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): self
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();
        $self->nearestStorm = NearestStorm::fromArray($data);

        if (array_key_exists('apparentTemperature', $data)) {
            $self->apparentTemperature = new ApparentTemperature($data['apparentTemperature'], $data['units']);
        }

        if (array_key_exists('temperature', $data)) {
            $self->temperature = new Temperature($data['temperature'], $data['units']);
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return self::extend($self, $data);
    }

    /**
     * @return ApparentTemperature
     */
    public function getApparentTemperature(): ?ApparentTemperature
    {
        return $this->apparentTemperature;
    }

    /**
     * @return Temperature
     */
    public function getTemperature(): ?Temperature
    {
        return $this->temperature;
    }

    /**
     * @return NearestStorm
     */
    public function getNearestStorm(): NearestStorm
    {
        return $this->nearestStorm;
    }
}

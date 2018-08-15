<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity\DataPoint;

use philwc\DarkSky\Entity\DataPoint;
use philwc\DarkSky\Value\Float\ApparentTemperature;
use philwc\DarkSky\Value\Float\PrecipAccumulation;
use philwc\DarkSky\Value\Float\Temperature;

/**
 * Class HourlyDataPoint
 * @package philwc\DarkSky\Entity\DataPoint
 */
class HourlyDataPoint extends DataPoint
{
    /**
     * @var PrecipAccumulation
     */
    private $precipAccumulation;

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
     * @return HourlyDataPoint
     * @throws \philwc\DarkSky\Exception\InvalidDateFieldException
     * @throws \philwc\DarkSky\Exception\MissingDataException
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): self
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();
        if (array_key_exists('precipAccumulation', $data)) {
            $self->precipAccumulation = new PrecipAccumulation($data['precipAccumulation'], $data['units']);
        }

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
     * @return PrecipAccumulation
     */
    public function getPrecipAccumulation(): ?PrecipAccumulation
    {
        return $this->precipAccumulation;
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
}

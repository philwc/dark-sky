<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity\DataPoint;

use philwc\DarkSky\Entity\DataPoint;

/**
 * Class HourlyDataPoint
 * @package philwc\DarkSky\Entity\DataPoint
 */
class HourlyDataPoint extends DataPoint
{
    /**
     * @var float
     */
    private $precipAccumulation;

    /**
     * @var float
     */
    private $apparentTemperature;

    /**
     * @var float
     */
    private $temperature;

    /**
     * @param array $data
     * @return HourlyDataPoint
     * @throws \philwc\DarkSky\Exception\InvalidDateFieldException
     * @throws \philwc\DarkSky\Exception\MissingDataException
     */
    public static function fromArray(array $data): self
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();
        if (array_key_exists('precipAccumulation', $data)) {
            $self->precipAccumulation = (float)$data['precipAccumulation'];
        }

        if (array_key_exists('apparentTemperature', $data)) {
            $self->apparentTemperature = (float)$data['apparentTemperature'];
        }

        if (array_key_exists('temperature', $data)) {
            $self->temperature = (float)$data['temperature'];
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return self::extend($self, $data);
    }

    /**
     * @return float
     */
    public function getPrecipAccumulation(): ?float
    {
        return $this->precipAccumulation;
    }

    /**
     * @return float
     */
    public function getApparentTemperature(): ?float
    {
        return $this->apparentTemperature;
    }

    /**
     * @return float
     */
    public function getTemperature(): ?float
    {
        return $this->temperature;
    }
}

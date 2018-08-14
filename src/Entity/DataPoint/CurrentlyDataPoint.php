<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity\DataPoint;

use philwc\DarkSky\Entity\DataPoint;
use philwc\DarkSky\Entity\Storm;

/**
 * Class CurrentlyDataPoint
 * @package philwc\DarkSky\Entity\DataPoint
 */
class CurrentlyDataPoint extends DataPoint
{
    /**
     * @var Storm
     */
    private $storm;

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
     * @return CurrentlyDataPoint
     * @throws \philwc\DarkSky\Exception\InvalidDateFieldException
     * @throws \philwc\DarkSky\Exception\MissingDataException
     */
    public static function fromArray(array $data): self
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();
        $self->storm = Storm::fromArray($data);

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

    /**
     * @return Storm
     */
    public function getStorm(): Storm
    {
        return $this->storm;
    }
}

<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity\DataPoint;

use philwc\DarkSky\Entity\DataPoint;
use philwc\DarkSky\Value\Bearing;

/**
 * Class CurrentlyDataPoint
 * @package philwc\DarkSky\Entity\DataPoint
 */
class CurrentlyDataPoint extends DataPoint
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

        if (array_key_exists('nearestStormBearing', $data)) {
            $self->nearestStormBearing = new Bearing($data['nearestStormBearing']);
        }

        if (array_key_exists('nearestStormDistance', $data)) {
            $self->nearestStormDistance = (int)$data['nearestStormDistance'];
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

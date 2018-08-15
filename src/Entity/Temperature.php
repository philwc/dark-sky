<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\DateTimeHelper;
use philwc\DarkSky\Value\DateTimeImmutable\HighTime;
use philwc\DarkSky\Value\DateTimeImmutable\LowTime;
use philwc\DarkSky\Value\Float\Temperature as TemperatureValue;
use philwc\DarkSky\Value\Float\TemperatureHigh;
use philwc\DarkSky\Value\Float\TemperatureLow;

/**
 * Class Temperature
 * @package philwc\DarkSky\Entity
 */
class Temperature extends Entity
{
    /**
     * @var TemperatureHigh
     */
    private $temperatureHigh;

    /**
     * @var HighTime
     */
    private $temperatureHighTime;

    /**
     * @var TemperatureLow
     */
    private $temperatureLow;

    /**
     * @var LowTime
     */
    private $temperatureLowTime;

    /**
     * @var TemperatureValue
     */
    private $temperature;

    /**
     * @param array $data
     * @return self
     * @throws \philwc\DarkSky\Exception\InvalidDateFieldException
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): self
    {
        /** @var \DateTimeZone $timezone */
        $timezone = $data['timezone'];

        $self = new self();

        if (array_key_exists('temperatureHigh', $data)) {
            $self->temperatureHigh = new TemperatureHigh($data['temperatureHigh'], $data['units']);
        }

        if (array_key_exists('temperatureHighTime', $data)) {
            $self->temperatureHighTime = new HighTime(
                DateTimeHelper::getDateTimeImmutable(
                    $data,
                    'temperatureHighTime',
                    $timezone
                )
            );
        }

        if (array_key_exists('temperatureLow', $data)) {
            $self->temperatureLow = new TemperatureLow($data['temperatureLow'], $data['units']);
        }

        if (array_key_exists('temperatureLowTime', $data)) {
            $self->temperatureLowTime = new LowTime(
                DateTimeHelper::getDateTimeImmutable(
                    $data,
                    'temperatureLowTime',
                    $timezone
                )
            );
        }

        if (array_key_exists('temperature', $data)) {
            $self->temperature = new TemperatureValue($data['temperature'], $data['units']);
        }

        return $self;
    }

    /**
     * @return TemperatureHigh
     */
    public function getHigh(): ?TemperatureHigh
    {
        return $this->temperatureHigh;
    }

    /**
     * @return HighTime
     */
    public function getHighTime(): ?HighTime
    {
        return $this->temperatureHighTime;
    }

    /**
     * @return TemperatureLow
     */
    public function getLow(): ?TemperatureLow
    {
        return $this->temperatureLow;
    }

    /**
     * @return LowTime
     */
    public function getLowTime(): ?LowTime
    {
        return $this->temperatureLowTime;
    }

    /**
     * @return TemperatureValue
     */
    public function getTemperature(): ?TemperatureValue
    {
        return $this->temperature;
    }
}

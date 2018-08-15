<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\DateTimeHelper;
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
     * @var \DateTimeImmutable
     */
    private $temperatureHighTime;

    /**
     * @var TemperatureLow
     */
    private $temperatureLow;

    /**
     * @var \DateTimeImmutable
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
            $self->temperatureHighTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'temperatureHighTime',
                $timezone
            );
        }

        if (array_key_exists('temperatureLow', $data)) {
            $self->temperatureLow = new TemperatureLow($data['temperatureLow'], $data['units']);
        }

        if (array_key_exists('temperatureLowTime', $data)) {
            $self->temperatureLowTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'temperatureLowTime',
                $timezone
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
     * @return \DateTimeImmutable
     */
    public function getHighTime(): ?\DateTimeImmutable
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
     * @return \DateTimeImmutable
     */
    public function getLowTime(): ?\DateTimeImmutable
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

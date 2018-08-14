<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\DateTimeHelper;

/**
 * Class Temperature
 * @package philwc\DarkSky\Entity
 */
class Temperature extends Entity
{
    /**
     * @var float
     */
    private $temperatureHigh;

    /**
     * @var \DateTimeImmutable
     */
    private $temperatureHighTime;

    /**
     * @var float
     */
    private $temperatureLow;

    /**
     * @var \DateTimeImmutable
     */
    private $temperatureLowTime;

    /**
     * @var float
     */
    private $temperature;

    /**
     * @param array $data
     * @return self
     * @throws \philwc\DarkSky\Exception\InvalidDateFieldException
     */
    public static function fromArray(array $data): self
    {
        /** @var \DateTimeZone $timezone */
        $timezone = $data['timezone'];

        $self = new self();

        if (array_key_exists('temperatureHigh', $data)) {
            $self->temperatureHigh = (float)$data['temperatureHigh'];
        }

        if (array_key_exists('temperatureHighTime', $data)) {
            $self->temperatureHighTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'temperatureHighTime',
                $timezone
            );
        }

        if (array_key_exists('temperatureLow', $data)) {
            $self->temperatureLow = (float)$data['temperatureLow'];
        }

        if (array_key_exists('temperatureLowTime', $data)) {
            $self->temperatureLowTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'temperatureLowTime',
                $timezone
            );
        }

        if (array_key_exists('temperature', $data)) {
            $self->temperature = (float)$data['temperature'];
        }

        return $self;
    }

    /**
     * @return float
     */
    public function getHigh(): ?float
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
     * @return float
     */
    public function getLow(): ?float
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
     * @return float
     */
    public function getTemperature(): ?float
    {
        return $this->temperature;
    }
}

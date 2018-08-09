<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\DateTimeHelper;

/**
 * Class ApparentTemperature
 * @package philwc\DarkSky\Entity
 */
class ApparentTemperature implements EntityInterface
{
    /**
     * @var float
     */
    private $apparentTemperatureHigh;

    /**
     * @var \DateTimeImmutable
     */
    private $apparentTemperatureHighTime;

    /**
     * @var float
     */
    private $apparentTemperatureLow;

    /**
     * @var \DateTimeImmutable
     */
    private $apparentTemperatureLowTime;

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

        if (array_key_exists('apparentTemperatureHigh', $data)) {
            $self->apparentTemperatureHigh = (float)$data['apparentTemperatureHigh'];
        }

        if (array_key_exists('apparentTemperatureHighTime', $data)) {
            $self->apparentTemperatureHighTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'apparentTemperatureHighTime',
                $timezone
            );
        }

        if (array_key_exists('apparentTemperatureLow', $data)) {
            $self->apparentTemperatureLow = (float)$data['apparentTemperatureLow'];
        }

        if (array_key_exists('apparentTemperatureLowTime', $data)) {
            $self->apparentTemperatureLowTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'apparentTemperatureLowTime',
                $timezone
            );
        }

        return $self;
    }

    /**
     * @return float
     */
    public function getHigh(): ?float
    {
        return $this->apparentTemperatureHigh;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getHighTime(): ?\DateTimeImmutable
    {
        return $this->apparentTemperatureHighTime;
    }

    /**
     * @return float
     */
    public function getLow(): ?float
    {
        return $this->apparentTemperatureLow;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getLowTime(): ?\DateTimeImmutable
    {
        return $this->apparentTemperatureLowTime;
    }
}

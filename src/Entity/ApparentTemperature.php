<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\DateTimeHelper;
use philwc\DarkSky\Value\Float\ApparentTemperatureHigh;
use philwc\DarkSky\Value\Float\ApparentTemperatureLow;

/**
 * Class ApparentTemperature
 * @package philwc\DarkSky\Entity
 */
class ApparentTemperature extends Entity
{
    /**
     * @var ApparentTemperatureHigh
     */
    private $apparentTemperatureHigh;

    /**
     * @var \DateTimeImmutable
     */
    private $apparentTemperatureHighTime;

    /**
     * @var ApparentTemperatureLow
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
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): self
    {
        /** @var \DateTimeZone $timezone */
        $timezone = $data['timezone'];

        $self = new self();

        if (array_key_exists('apparentTemperatureHigh', $data)) {
            $self->apparentTemperatureHigh =
                new ApparentTemperatureHigh($data['apparentTemperatureHigh'], $data['units']);
        }

        if (array_key_exists('apparentTemperatureHighTime', $data)) {
            $self->apparentTemperatureHighTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'apparentTemperatureHighTime',
                $timezone
            );
        }

        if (array_key_exists('apparentTemperatureLow', $data)) {
            $self->apparentTemperatureLow = new ApparentTemperatureLow($data['apparentTemperatureLow'], $data['units']);
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
     * @return ApparentTemperatureHigh
     */
    public function getHigh(): ?ApparentTemperatureHigh
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
     * @return ApparentTemperatureLow
     */
    public function getLow(): ?ApparentTemperatureLow
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

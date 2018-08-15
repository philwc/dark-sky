<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\DateTimeHelper;
use philwc\DarkSky\Value\DateTimeImmutable\ApparentTemperatureHighTime;
use philwc\DarkSky\Value\DateTimeImmutable\ApparentTemperatureLowTime;
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
     * @var ApparentTemperatureHighTime
     */
    private $apparentTemperatureHighTime;

    /**
     * @var ApparentTemperatureLow
     */
    private $apparentTemperatureLow;

    /**
     * @var ApparentTemperatureLowTime
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
            $self->apparentTemperatureHighTime = new ApparentTemperatureHighTime(
                DateTimeHelper::getDateTimeImmutable(
                    $data,
                    'apparentTemperatureHighTime',
                    $timezone
                )
            );
        }

        if (array_key_exists('apparentTemperatureLow', $data)) {
            $self->apparentTemperatureLow = new ApparentTemperatureLow($data['apparentTemperatureLow'], $data['units']);
        }

        if (array_key_exists('apparentTemperatureLowTime', $data)) {
            $self->apparentTemperatureLowTime = new ApparentTemperatureLowTime(
                DateTimeHelper::getDateTimeImmutable(
                    $data,
                    'apparentTemperatureLowTime',
                    $timezone
                )
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
     * @return ApparentTemperatureHighTime
     */
    public function getHighTime(): ?ApparentTemperatureHighTime
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
     * @return ApparentTemperatureLowTime
     */
    public function getLowTime(): ?ApparentTemperatureLowTime
    {
        return $this->apparentTemperatureLowTime;
    }
}

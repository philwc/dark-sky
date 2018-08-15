<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

/**
 * Class ApparentTemperatureLowTime
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
final class ApparentTemperatureLowTime extends DateTimeImmutableValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Apparent Temperature Low Time';
    }
}

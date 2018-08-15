<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

/**
 * Class ApparentTemperatureHighTime
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
final class ApparentTemperatureHighTime extends DateTimeImmutableValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Apparent Temperature High Time';
    }
}

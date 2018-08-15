<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

/**
 * Class SunriseTime
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
final class SunsetTime extends DateTimeImmutableValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Sunset Time';
    }
}

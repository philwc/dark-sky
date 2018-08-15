<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

/**
 * Class SunriseTime
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
final class SunriseTime extends DateTimeImmutableValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Sunrise Time';
    }
}

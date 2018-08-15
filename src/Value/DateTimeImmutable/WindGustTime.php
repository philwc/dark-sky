<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

/**
 * Class WindGustTime
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
final class WindGustTime extends DateTimeImmutableValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Wind Gust Time';
    }
}

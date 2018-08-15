<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

/**
 * Class PrecipIntensityMaxTime
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
final class PrecipIntensityMaxTime extends DateTimeImmutableValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Precipitation Intensity Max Time';
    }
}

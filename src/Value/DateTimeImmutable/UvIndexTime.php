<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

/**
 * Class UvIndexTime
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
final class UvIndexTime extends DateTimeImmutableValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'UV Index Time';
    }
}

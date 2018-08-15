<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

/**
 * Class Time
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
final class Time extends DateTimeImmutableValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Time';
    }
}

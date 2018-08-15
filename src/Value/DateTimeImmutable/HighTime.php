<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

/**
 * Class HighTime
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
final class HighTime extends DateTimeImmutableValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'High Time';
    }
}

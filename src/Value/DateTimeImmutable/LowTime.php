<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

/**
 * Class LowTime
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
final class LowTime extends DateTimeImmutableValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Low Time';
    }
}

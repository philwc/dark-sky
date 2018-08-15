<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

/**
 * Class Expires
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
final class Expires extends DateTimeImmutableValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Expires';
    }
}

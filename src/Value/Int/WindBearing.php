<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Int;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class WindBearing
 * @package philwc\DarkSky\Value\Int
 */
final class WindBearing extends IntValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Wind Bearing';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return '°';
    }

    /**
     * @param $value
     * @throws AssertionFailedException
     */
    protected function assertValue($value): void
    {
        Assertion::between($value, 0, 360);
    }
}

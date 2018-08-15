<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class Latitude
 * @package philwc\DarkSky\Value
 */
final class Latitude extends FloatValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Latitude';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return '°';
    }

    /**
     * @throws AssertionFailedException
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        Assertion::between($value, -90, 90);
    }
}

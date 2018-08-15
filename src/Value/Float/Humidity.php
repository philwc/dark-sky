<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class Humidity
 * @package philwc\DarkSky\Value
 */
final class Humidity extends FloatValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Humidity';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return '';
    }

    /**
     * @throws AssertionFailedException
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        Assertion::between($value, 0, 1);
    }
}

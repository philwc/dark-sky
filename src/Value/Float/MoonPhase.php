<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class MoonPhase
 * @package philwc\DarkSky\Value
 */
final class MoonPhase extends FloatValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Moon Phase';
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

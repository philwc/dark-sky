<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class Visibility
 * @package philwc\DarkSky\Value
 */
final class Visibility extends FloatValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Visibility';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        if (\in_array($this->units->toString(), ['us', 'uk2'], true)) {
            return 'miles';
        }

        return 'kilometers';
    }

    /**
     * @throws AssertionFailedException
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        Assertion::between($value, 0, 16.09);
    }
}

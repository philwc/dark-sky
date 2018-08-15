<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class CloudCover
 * @package philwc\DarkSky\Value
 */
final class CloudCover extends FloatValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Cloud Cover';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return '%';
    }

    /**
     * @return float
     */
    public function toFloat(): float
    {
        return parent::toFloat() * 100;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return parent::getValue() * 100;
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

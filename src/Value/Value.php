<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value;

use Assert\AssertionFailedException;

/**
 * Class Value
 * @package philwc\DarkSky\Value
 */
abstract class Value
{
    /**
     * @var int|float|string
     */
    protected $value;

    /**
     * @return string
     */
    abstract public function getTitle(): string;

    /**
     * @return string
     */
    abstract public function getUnits(): string;

    /**
     * @throws AssertionFailedException
     * @param mixed $value
     */
    abstract protected function assertValue($value): void;

    /**
     * @return string
     */
    public function toString(): string
    {
        return trim($this->getValue() . ' ' . $this->getUnits());
    }

    /**
     * @return float|int|string
     */
    public function getValue()
    {
        return $this->value;
    }
}

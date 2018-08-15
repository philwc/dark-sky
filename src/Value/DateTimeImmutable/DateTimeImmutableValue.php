<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\DateTimeImmutable;

use philwc\DarkSky\Value\Value;

/**
 * Class DateTimeImmutableValue
 * @package philwc\DarkSky\Value\DateTimeImmutable
 */
abstract class DateTimeImmutableValue extends Value
{
    /**
     * DateTimeImmutableValue constructor.
     * @param \DateTimeImmutable $value
     */
    public function __construct(\DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return '';
    }

    /**
     * @return \DateTimeImmutable
     */
    public function toDateTimeImmutable(): \DateTimeImmutable
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value->format('l, jS, F Y H:i:s');
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}

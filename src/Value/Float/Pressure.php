<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

/**
 * Class Pressure
 * @package philwc\DarkSky\Value\Float
 */
final class Pressure extends FloatValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Pressure';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return 'mbar';
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}

<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

/**
 * Class DewPoint
 * @package philwc\DarkSky\Value\Float
 */
final class DewPoint extends FloatValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Dew Point';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        if ($this->units->toString() === 'us') {
            return '°F';
        }
        return '°C';
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}

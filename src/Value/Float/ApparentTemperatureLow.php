<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

/**
 * Class ApparentTemperatureLow
 * @package philwc\DarkSky\Value\Float
 */
final class ApparentTemperatureLow extends FloatValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Apparent Temperature Low';
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

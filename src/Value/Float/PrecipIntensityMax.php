<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

/**
 * Class PrecipIntensityMax
 * @package philwc\DarkSky\Value\Float
 */
final class PrecipIntensityMax extends FloatValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Maximum Precipitation Intensity';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        if ($this->units->toString() === 'us') {
            return 'inches per hour';
        }
        return 'mm per hour';
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}

<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

/**
 * Class PrecipAccumulation
 * @package philwc\DarkSky\Value\Float
 */
final class PrecipAccumulation extends FloatValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Precipitation Accumulation';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        if ($this->units->toString() === 'us') {
            return 'inches';
        }
        return 'cm';
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}

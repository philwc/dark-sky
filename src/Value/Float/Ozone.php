<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

/**
 * Class Ozone
 * @package philwc\DarkSky\Value\Float
 */
final class Ozone extends FloatValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Ozone';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return 'DU';
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}

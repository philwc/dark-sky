<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

/**
 * Class WindGust
 * @package philwc\DarkSky\Value\Float
 */
final class WindSpeed extends FloatValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Wind Speed';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        if (\in_array($this->units->toString(), ['us', 'uk2', 'ca'], true)) {
            return 'miles per hour';
        }

        return 'metres per second';
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}

<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

/**
 * Class NearestStation
 * @package philwc\DarkSky\Value\Float
 */
final class NearestStation extends FloatValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Nearest Station';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        if (\in_array($this->units->toString(), ['us', 'uk2'], true)) {
            return 'miles';
        }

        return 'kilometers';
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}

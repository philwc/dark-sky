<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Int;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class Bearing
 * @package philwc\DarkSky\Value
 */
final class NearestStormBearing extends IntValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Nearest Storm Bearing';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return '°';
    }

    /**
     * @param $value
     * @throws AssertionFailedException
     */
    protected function assertValue($value): void
    {
        Assertion::between($value, 0, 360);
    }
}

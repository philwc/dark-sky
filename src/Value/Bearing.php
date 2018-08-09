<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value;

use Assert\Assertion;

/**
 * Class Bearing
 * @package philwc\DarkSky\Value
 */
final class Bearing
{
    /**
     * @var int
     */
    private $value;

    /**
     * WindBearing constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assertion::between($value, 0, 360);

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        return $this->value;
    }
}

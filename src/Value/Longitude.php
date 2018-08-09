<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value;

use Assert\Assertion;

/**
 * Class Longitude
 * @package philwc\DarkSky\Value
 */
final class Longitude
{
    /**
     * @var float
     */
    private $value;

    /**
     * Longitude constructor.
     * @param float $value
     */
    public function __construct(float $value)
    {
        Assertion::between($value, -180, 180);

        $this->value = $value;
    }

    /**
     * @return float
     */
    public function toFloat(): float
    {
        return $this->value;
    }
}

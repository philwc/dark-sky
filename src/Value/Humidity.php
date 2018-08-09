<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value;

use Assert\Assertion;

/**
 * Class Humidity
 * @package philwc\DarkSky\Value
 */
final class Humidity
{
    /**
     * @var float
     */
    private $value;

    /**
     * Latitude constructor.
     * @param float $value
     */
    public function __construct(float $value)
    {
        Assertion::between($value, 0, 1);

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

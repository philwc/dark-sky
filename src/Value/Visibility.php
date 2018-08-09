<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value;

use Assert\Assertion;

/**
 * Class Visibility
 * @package philwc\DarkSky\Value
 */
final class Visibility
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
        Assertion::between($value, 0, 10);

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

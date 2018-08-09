<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value;

use Assert\Assertion;

/**
 * Class MoonPhase
 * @package philwc\DarkSky\Value
 */
final class MoonPhase
{
    /**
     * @var float
     */
    private $value;

    /**
     * MoonPhase constructor.
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

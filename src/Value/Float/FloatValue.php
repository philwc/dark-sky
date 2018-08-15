<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Float;

use philwc\DarkSky\Value\String\Units;
use philwc\DarkSky\Value\Value;

/**
 * Class FloatValue
 * @package philwc\DarkSky\Value\Float
 */
abstract class FloatValue extends Value
{
    /**
     * @var Units
     */
    protected $units;

    /**
     * FloatValue constructor.
     * @param float $value
     * @param Units $units
     * @throws \Assert\AssertionFailedException
     */
    public function __construct(float $value, Units $units = null)
    {
        $this->assertValue($value);

        $this->value = $value;

        if ($units === null) {
            $units = new Units(Units::DEFAULT_UNIT);
        }
        $this->units = $units;
    }

    /**
     * @return float
     */
    public function toFloat(): float
    {
        return $this->value;
    }
}

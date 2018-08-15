<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Int;

use philwc\DarkSky\Value\String\Units;
use philwc\DarkSky\Value\Value;

/**
 * Class FloatValue
 * @package philwc\DarkSky\Value\Float
 */
abstract class IntValue extends Value
{
    /**
     * @var Units
     */
    protected $units;

    /**
     * IntValue constructor.
     * @param int $value
     * @param Units $units
     * @throws \Assert\AssertionFailedException
     */
    public function __construct(int $value, Units $units = null)
    {
        $this->assertValue($value);

        $this->value = $value;
        if ($units === null) {
            $units = new Units(Units::DEFAULT_UNIT);
        }
        $this->units = $units;
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        return $this->value;
    }
}

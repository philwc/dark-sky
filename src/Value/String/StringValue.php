<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\String;

use philwc\DarkSky\Value\Value;

/**
 * Class FloatValue
 * @package philwc\DarkSky\Value\String
 */
abstract class StringValue extends Value
{
    /**
     * IntValue constructor.
     * @param string $value
     * @throws \Assert\AssertionFailedException
     */
    public function __construct(string $value)
    {
        $this->assertValue($value);

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return '';
    }
}

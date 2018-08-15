<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\String;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class PrecipType
 * @package philwc\DarkSky\Value
 */
final class PrecipType extends StringValue
{
    private const EXPECTED = [
        'rain',
        'snow',
        'sleet',
    ];

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Precipitation Type';
    }

    /**
     * @throws AssertionFailedException
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        Assertion::inArray($value, self::EXPECTED);
    }
}

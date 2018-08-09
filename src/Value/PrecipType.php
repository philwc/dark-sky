<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value;

use Assert\Assertion;

/**
 * Class PrecipType
 * @package philwc\DarkSky\Value
 */
final class PrecipType
{
    private const EXPECTED = [
        'rain',
        'snow',
        'sleet',
    ];

    /**
     * @var string
     */
    private $value;

    /**
     * PrecipType constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assertion::inArray($value, self::EXPECTED);

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }
}

<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value;

use Assert\Assertion;

/**
 * Class Icon
 * @package philwc\DarkSky\Value
 */
final class Icon
{
    private const EXPECTED = [
        'clear-day',
        'clear-night',
        'rain', 'snow',
        'sleet',
        'wind',
        'fog',
        'cloudy',
        'partly-cloudy-day',
        'partly-cloudy-night',
    ];

    /**
     * @var string
     */
    private $value;

    /**
     * Icon constructor.
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

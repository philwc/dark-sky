<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value;

use Assert\Assertion;

/**
 * Class Source
 * @package philwc\DarkSky\Value
 */
final class Source
{
    private const EXPECTED = [
        'cmc',
        'darksky',
        'dwdpa',
        'ecpa',
        'gfs',
        'hrrr',
        'icon',
        'isd',
        'madis',
        'metno',
        'metwarn',
        'nam',
        'nwspa',
        'sref',
        'nearest-precip'
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

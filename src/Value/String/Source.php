<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\String;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class Source
 * @package philwc\DarkSky\Value
 */
final class Source extends StringValue
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
     * @return string
     */
    public function getTitle(): string
    {
        return 'Source';
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

<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\String;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class Units
 * @package philwc\DarkSky\Value
 */
final class Units extends StringValue
{
    public const DEFAULT_UNIT = 'us';
    private const EXPECTED = [
        'auto',
        'ca',
        'uk2',
        'us',
        'si',
    ];

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Units';
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

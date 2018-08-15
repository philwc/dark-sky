<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\String;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class Lang
 * @package philwc\DarkSky\Value
 */
final class Lang extends StringValue
{
    public const DEFAULT_LANG = 'en';
    private const EXPECTED = [
        'ar',
        'az',
        'be',
        'bg',
        'bs',
        'ca',
        'cs',
        'da',
        'de',
        'el',
        'en',
        'es',
        'et',
        'fi',
        'fr',
        'he',
        'hr',
        'hu',
        'id',
        'is',
        'it',
        'ja',
        'ka',
        'ko',
        'kw',
        'nb',
        'nl',
        'no',
        'pl',
        'pt',
        'ro',
        'ru',
        'sk',
        'sl',
        'sr',
        'sv',
        'tet',
        'tr',
        'uk',
        'x-pig-latin',
        'zh',
        'zh-tw',
    ];

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Language';
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

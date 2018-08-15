<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Int;

/**
 * Class UvIndex
 * @package philwc\DarkSky\Value\Int
 */
final class UvIndex extends IntValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'UV Index';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return '';
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}

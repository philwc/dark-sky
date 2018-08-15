<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\String;

/**
 * Class Summary
 * @package philwc\DarkSky\Value\String
 */
class Summary extends StringValue
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Summary';
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}

<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\Int;

/**
 * Class NearestStormDistance
 * @package philwc\DarkSky\Value\Int
 */
final class NearestStormDistance extends IntValue
{

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Nearest Storm Distance';
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        if (\in_array($this->units->toString(), ['us', 'uk2'], true)) {
            return 'miles';
        }

        return 'kilometers';
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}

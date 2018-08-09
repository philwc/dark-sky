<?php
declare(strict_types=1);

namespace philwc\DarkSky;

use philwc\DarkSky\Exception\InvalidDateFieldException;

/**
 * Class DateTimeHelper
 * @package philwc\DarkSky
 */
class DateTimeHelper
{
    /**
     * @param array $data
     * @param string $field
     * @param \DateTimeZone $timezone
     * @return \DateTimeImmutable
     * @throws InvalidDateFieldException
     */
    public static function getDateTimeImmutable(
        array $data,
        string $field,
        \DateTimeZone $timezone
    ): \DateTimeImmutable
    {
        try {
            return new \DateTimeImmutable('@' . $data[$field], $timezone);
        } catch (\Exception $e) {
            throw new InvalidDateFieldException(
                sprintf('Invalid date value (%s) for field `%s`. ', $data[$field], $field),
                $e->getCode(),
                $e
            );
        }
    }
}

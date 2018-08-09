<?php
declare(strict_types=1);

namespace philwc\DarkSky;

use PHPUnit\Framework\TestCase;

/**
 * Class DateTimeHelperTest
 * @package philwc\DarkSky
 * @covers \philwc\DarkSky\DateTimeHelper
 */
class DateTimeHelperTest extends TestCase
{
    /**
     * @expectedException \philwc\DarkSky\Exception\InvalidDateFieldException
     */
    public function testInvalidDate(): void
    {
        $data['test'] = '';
        $timezone = new \DateTimeZone('Europe/London');

        DateTimeHelper::getDateTimeImmutable($data, 'test', $timezone);
    }
}

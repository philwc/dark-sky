<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity\DataPoint;

use philwc\DarkSky\Entity\DataPoint;
use philwc\DarkSky\Value\Float\ApparentTemperature;

/**
 * Class MinutelyDataPoint
 * @package philwc\DarkSky\Entity\DataPoint
 */
class MinutelyDataPoint extends DataPoint
{
    /**
     * @var ApparentTemperature
     */
    private $apparentTemperature;

    /**
     * @param array $data
     * @return MinutelyDataPoint
     * @throws \philwc\DarkSky\Exception\InvalidDateFieldException
     * @throws \philwc\DarkSky\Exception\MissingDataException
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): self
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();

        if (array_key_exists('apparentTemperature', $data)) {
            $self->apparentTemperature = new ApparentTemperature($data['apparentTemperature'], $data['units']);
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return self::extend($self, $data);
    }

    /**
     * @return ApparentTemperature
     */
    public function getApparentTemperature(): ?ApparentTemperature
    {
        return $this->apparentTemperature;
    }
}

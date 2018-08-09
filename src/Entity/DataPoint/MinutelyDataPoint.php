<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity\DataPoint;

use philwc\DarkSky\Entity\DataPoint;

/**
 * Class MinutelyDataPoint
 * @package philwc\DarkSky\Entity\DataPoint
 */
class MinutelyDataPoint extends DataPoint
{
    /**
     * @var float
     */
    private $apparentTemperature;

    /**
     * @param array $data
     * @return MinutelyDataPoint
     * @throws \philwc\DarkSky\Exception\InvalidDateFieldException
     * @throws \philwc\DarkSky\Exception\MissingDataException
     */
    public static function fromArray(array $data): self
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();

        if (array_key_exists('apparentTemperature', $data)) {
            $self->apparentTemperature = (float)$data['apparentTemperature'];
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return self::extend($self, $data);
    }

    /**
     * @return float
     */
    public function getApparentTemperature(): ?float
    {
        return $this->apparentTemperature;
    }
}

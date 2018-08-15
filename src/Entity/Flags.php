<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Value\Float\NearestStation;
use philwc\DarkSky\Value\String\Source;
use philwc\DarkSky\Value\String\Units;

/**
 * Class Flags
 * @package philwc\DarkSky\Entity
 */
class Flags extends Entity
{
    /**
     * @var bool
     */
    private $darkskyUnavailable;

    /**
     * @var Source[]
     */
    private $sources;

    /**
     * @var NearestStation
     */
    private $nearestStation;

    /**
     * @var Units
     */
    private $units;

    /**
     * @return array
     */
    protected static function getRequiredFields(): array
    {
        return [
            'nearest-station',
            'sources',
            'units'
        ];
    }

    /**
     * @param array $data
     * @return Flags
     * @throws \philwc\DarkSky\Exception\MissingDataException
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): Flags
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();

        $self->units = new Units($data['units']);

        $self->nearestStation = new NearestStation($data['nearest-station'], $self->units);

        $self->sources = array_map(function ($source) {
            return new Source($source);
        }, $data['sources']);


        if (array_key_exists('darksky-unavailable', $data)) {
            $self->darkskyUnavailable = $data['darksky-unavailable'];
        }

        return $self;
    }

    /**
     * @return bool
     */
    public function isDarkskyUnavailable(): bool
    {
        return $this->darkskyUnavailable;
    }

    /**
     * @return Source[]
     */
    public function getSources(): array
    {
        return $this->sources;
    }

    /**
     * @return NearestStation
     */
    public function getNearestStation(): NearestStation
    {
        return $this->nearestStation;
    }

    /**
     * @return Units
     */
    public function getUnits(): Units
    {
        return $this->units;
    }
}

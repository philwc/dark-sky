<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Value\Source;

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
     * @var float
     */
    private $nearestStation;

    /**
     * @var string
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
     */
    public static function fromArray(array $data): Flags
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();

        $self->nearestStation = $data['nearest-station'];

        $self->sources = array_map(function ($source) {
            return new Source($source);
        }, $data['sources']);

        $self->units = $data['units'];

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
     * @return float
     */
    public function getNearestStation(): float
    {
        return $this->nearestStation;
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return $this->units;
    }
}

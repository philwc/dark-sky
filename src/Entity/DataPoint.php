<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\DateTimeHelper;
use philwc\DarkSky\Exception\InvalidDateFieldException;
use philwc\DarkSky\Value\Float\CloudCover;
use philwc\DarkSky\Value\Float\DewPoint;
use philwc\DarkSky\Value\Float\Humidity;
use philwc\DarkSky\Value\Float\Ozone;
use philwc\DarkSky\Value\Float\Pressure;
use philwc\DarkSky\Value\Int\UvIndex;
use philwc\DarkSky\Value\String\Icon;
use philwc\DarkSky\Value\Float\Visibility;

/**
 * Class DataPoint
 * @package philwc\DarkSky\Entity
 */
abstract class DataPoint extends Entity
{
    /**
     * @var CloudCover
     */
    private $cloudCover;
    /**
     * @var DewPoint
     */
    private $dewPoint;
    /**
     * @var Humidity
     */
    private $humidity;

    /**
     * @var Icon
     */
    private $icon;

    /**
     * @var Ozone
     */
    private $ozone;

    /**
     * @var Pressure
     */
    private $pressure;

    /**
     * @var string
     */
    private $summary;

    /**
     * @var \DateTimeImmutable
     */
    private $time;

    /**
     * @var UvIndex
     */
    private $uvIndex;

    /**
     * @var Visibility
     */
    private $visibility;

    /**
     * @var Precipitation
     */
    private $precipitation;

    /**
     * @var Wind
     */
    private $wind;

    /**
     * @return array
     */
    protected static function getRequiredFields(): array
    {
        return ['time'];
    }

    /**
     * @param DataPoint $self
     * @param array $data
     * @return DataPoint
     * @throws InvalidDateFieldException
     * @throws \Assert\AssertionFailedException
     */
    protected static function extend(DataPoint $self, array $data): DataPoint
    {
        $self->precipitation = Precipitation::fromArray($data);
        $self->wind = Wind::fromArray($data);

        if (array_key_exists('cloudCover', $data)) {
            $self->cloudCover = new CloudCover($data['cloudCover'], $data['units']);
        }

        if (array_key_exists('dewPoint', $data)) {
            $self->dewPoint = new DewPoint($data['dewPoint'], $data['units']);
        }

        if (array_key_exists('humidity', $data)) {
            $self->humidity = new Humidity($data['humidity'], $data['units']);
        }

        if (array_key_exists('icon', $data)) {
            $self->icon = new Icon($data['icon']);
        }

        if (array_key_exists('ozone', $data)) {
            $self->ozone = new Ozone($data['ozone'], $data['units']);
        }

        if (array_key_exists('pressure', $data)) {
            $self->pressure = new Pressure($data['pressure'], $data['units']);
        }

        if (array_key_exists('summary', $data)) {
            $self->summary = $data['summary'];
        }

        if (array_key_exists('uvIndex', $data)) {
            $self->uvIndex = new UvIndex($data['uvIndex'], $data['units']);
        }

        if (array_key_exists('visibility', $data)) {
            $self->visibility = new Visibility($data['visibility'], $data['units']);
        }

        /** @var \DateTimeZone $timezone */
        $timezone = $data['timezone'];
        $self->time = DateTimeHelper::getDateTimeImmutable($data, 'time', $timezone);

        return $self;
    }

    /**
     * @return CloudCover
     */
    public function getCloudCover(): ?CloudCover
    {
        return $this->cloudCover;
    }

    /**
     * @return DewPoint
     */
    public function getDewPoint(): ?DewPoint
    {
        return $this->dewPoint;
    }

    /**
     * @return Humidity
     */
    public function getHumidity(): ?Humidity
    {
        return $this->humidity;
    }

    /**
     * @return Icon
     */
    public function getIcon(): ?Icon
    {
        return $this->icon;
    }

    /**
     * @return Ozone
     */
    public function getOzone(): ?Ozone
    {
        return $this->ozone;
    }

    /**
     * @return Pressure
     */
    public function getPressure(): ?Pressure
    {
        return $this->pressure;
    }

    /**
     * @return string
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getTime(): \DateTimeImmutable
    {
        return $this->time;
    }

    /**
     * @return UvIndex
     */
    public function getUvIndex(): ?UvIndex
    {
        return $this->uvIndex;
    }

    /**
     * @return Visibility
     */
    public function getVisibility(): ?Visibility
    {
        return $this->visibility;
    }

    /**
     * @return Precipitation
     */
    public function getPrecipitation(): Precipitation
    {
        return $this->precipitation;
    }

    /**
     * @return Wind
     */
    public function getWind(): Wind
    {
        return $this->wind;
    }
}

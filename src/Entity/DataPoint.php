<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\DateTimeHelper;
use philwc\DarkSky\Exception\InvalidDateFieldException;
use philwc\DarkSky\Value\CloudCover;
use philwc\DarkSky\Value\Humidity;
use philwc\DarkSky\Value\Icon;
use philwc\DarkSky\Value\Visibility;
use philwc\DarkSky\Value\Bearing;

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
     * @var float
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
     * @var float
     */
    private $ozone;

    /**
     * @var float
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
     * @var int
     */
    private $uvIndex;

    /**
     * @var Visibility
     */
    private $visibility;

    /**
     * @var Bearing
     */
    private $windBearing;

    /**
     * @var float
     */
    private $windGust;

    /**
     * @var float
     */
    private $windSpeed;

    /**
     * @var Precipitation
     */
    private $precipitation;

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
     */
    protected static function extend(DataPoint $self, array $data): DataPoint
    {
        $self->precipitation = Precipitation::fromArray($data);

        if (array_key_exists('cloudCover', $data)) {
            $self->cloudCover = new CloudCover($data['cloudCover']);
        }

        if (array_key_exists('dewPoint', $data)) {
            $self->dewPoint = (float)$data['dewPoint'];
        }

        if (array_key_exists('humidity', $data)) {
            $self->humidity = new Humidity($data['humidity']);
        }

        if (array_key_exists('icon', $data)) {
            $self->icon = new Icon($data['icon']);
        }

        if (array_key_exists('ozone', $data)) {
            $self->ozone = (float)$data['ozone'];
        }

        if (array_key_exists('pressure', $data)) {
            $self->pressure = (float)$data['pressure'];
        }

        if (array_key_exists('summary', $data)) {
            $self->summary = $data['summary'];
        }

        if (array_key_exists('uvIndex', $data)) {
            $self->uvIndex = (int)$data['uvIndex'];
        }

        if (array_key_exists('visibility', $data)) {
            $self->visibility = new Visibility($data['visibility']);
        }

        if (array_key_exists('windBearing', $data)) {
            $self->windBearing = new Bearing($data['windBearing']);
        }

        if (array_key_exists('windGust', $data)) {
            $self->windGust = (float)$data['windGust'];
        }

        if (array_key_exists('windSpeed', $data)) {
            $self->windSpeed = (float)$data['windSpeed'];
        }

        /** @var \DateTimeZone $timezone */
        $timezone = $data['timezone'];
        $self->time = DateTimeHelper::getDateTimeImmutable($data, 'time', $timezone);

        return $self;
    }

    /**
     * @return float
     */
    public function getCloudCover(): ?float
    {
        return $this->cloudCover->toFloat();
    }

    /**
     * @return float
     */
    public function getDewPoint(): ?float
    {
        return $this->dewPoint;
    }

    /**
     * @return float
     */
    public function getHumidity(): ?float
    {
        return $this->humidity->toFloat();
    }

    /**
     * @return string
     */
    public function getIcon(): ?string
    {
        return $this->icon->toString();
    }

    /**
     * @return float
     */
    public function getOzone(): ?float
    {
        return $this->ozone;
    }

    /**
     * @return float
     */
    public function getPressure(): ?float
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
     * @return int
     */
    public function getUvIndex(): ?int
    {
        return $this->uvIndex;
    }

    /**
     * @return float
     */
    public function getVisibility(): ?float
    {
        return $this->visibility->toFloat();
    }

    /**
     * @return int
     */
    public function getWindBearing(): ?int
    {
        return $this->windBearing->toInt();
    }

    /**
     * @return float
     */
    public function getWindGust(): ?float
    {
        return $this->windGust;
    }

    /**
     * @return float
     */
    public function getWindSpeed(): ?float
    {
        return $this->windSpeed;
    }

    /**
     * @return Precipitation
     */
    public function getPrecipitation(): Precipitation
    {
        return $this->precipitation;
    }
}

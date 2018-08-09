<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity\DataPoint;

use philwc\DarkSky\DateTimeHelper;
use philwc\DarkSky\Entity\ApparentTemperature;
use philwc\DarkSky\Entity\DataPoint;
use philwc\DarkSky\Entity\Temperature;
use philwc\DarkSky\Value\MoonPhase;

/**
 * Class DailyDataPoint
 * @package philwc\DarkSky\Entity\DataPoint
 */
class DailyDataPoint extends DataPoint
{

    /**
     * @var ApparentTemperature
     */
    private $apparentTemperature;

    /**
     * @var MoonPhase
     */
    private $moonPhase;

    /**
     * @var float
     */
    private $precipIntensityMax;

    /**
     * @var \DateTimeImmutable
     */
    private $precipIntensityMaxTime;

    /**
     * @var \DateTimeImmutable
     */
    private $sunriseTime;

    /**
     * @var \DateTimeImmutable
     */
    private $sunsetTime;


    /**
     * @var \DateTimeImmutable
     */
    private $uvIndexTime;

    /**
     * @var \DateTimeImmutable
     */
    private $windGustTime;

    /**
     * @var float
     */
    private $precipAccumulation;

    /**
     * @var Temperature
     */
    private $temperature;

    /**
     * @param array $data
     * @return DailyDataPoint
     * @throws \philwc\DarkSky\Exception\InvalidDateFieldException
     * @throws \philwc\DarkSky\Exception\MissingDataException
     */
    public static function fromArray(array $data): self
    {
        self::validate($data, self::getRequiredFields());

        /** @var \DateTimeZone $timezone */
        $timezone = $data['timezone'];

        $self = new self();

        $self->apparentTemperature = ApparentTemperature::fromArray($data);
        $self->temperature = Temperature::fromArray($data);

        if (array_key_exists('moonPhase', $data)) {
            $self->moonPhase = new MoonPhase($data['moonPhase']);
        }

        if (array_key_exists('precipIntensityMax', $data)) {
            $self->precipIntensityMax = (float)$data['precipIntensityMax'];
        }

        if (array_key_exists('precipIntensityMaxTime', $data)) {
            $self->precipIntensityMaxTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'precipIntensityMaxTime',
                $timezone
            );
        }

        if (array_key_exists('sunriseTime', $data)) {
            $self->sunriseTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'sunriseTime',
                $timezone
            );
        }

        if (array_key_exists('sunsetTime', $data)) {
            $self->sunsetTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'sunsetTime',
                $timezone
            );
        }

        if (array_key_exists('uvIndexTime', $data)) {
            $self->uvIndexTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'uvIndexTime',
                $timezone
            );
        }

        if (array_key_exists('windGustTime', $data)) {
            $self->windGustTime = DateTimeHelper::getDateTimeImmutable(
                $data,
                'windGustTime',
                $timezone
            );
        }

        if (array_key_exists('precipAccumulation', $data)) {
            $self->precipAccumulation = (float)$data['precipAccumulation'];
        }


        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return self::extend($self, $data);
    }

    /**
     * @return ApparentTemperature
     */
    public function getApparentTemperature(): ApparentTemperature
    {
        return $this->apparentTemperature;
    }

    /**
     * @return float
     */
    public function getMoonPhase(): ?float
    {
        return $this->moonPhase->toFloat();
    }

    /**
     * @return float
     */
    public function getPrecipIntensityMax(): ?float
    {
        return $this->precipIntensityMax;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getPrecipIntensityMaxTime(): ?\DateTimeImmutable
    {
        return $this->precipIntensityMaxTime;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getSunriseTime(): ?\DateTimeImmutable
    {
        return $this->sunriseTime;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getSunsetTime(): ?\DateTimeImmutable
    {
        return $this->sunsetTime;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUvIndexTime(): ?\DateTimeImmutable
    {
        return $this->uvIndexTime;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getWindGustTime(): ?\DateTimeImmutable
    {
        return $this->windGustTime;
    }

    /**
     * @return float
     */
    public function getPrecipAccumulation(): ?float
    {
        return $this->precipAccumulation;
    }

    /**
     * @return Temperature
     */
    public function getTemperature(): Temperature
    {
        return $this->temperature;
    }
}

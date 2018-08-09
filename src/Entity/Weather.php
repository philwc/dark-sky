<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Entity\DataPoint\CurrentlyDataPoint;
use philwc\DarkSky\Entity\DataPoint\DailyDataPoint;
use philwc\DarkSky\Entity\DataPoint\HourlyDataPoint;
use philwc\DarkSky\Entity\DataPoint\MinutelyDataPoint;
use philwc\DarkSky\EntityCollection\DailyDataPointCollection;
use philwc\DarkSky\EntityCollection\HourlyDataPointCollection;
use philwc\DarkSky\EntityCollection\MinutelyDataPointCollection;
use philwc\DarkSky\Exception\MissingDataException;
use philwc\DarkSky\Value\Latitude;
use philwc\DarkSky\Value\Longitude;
use philwc\DarkSky\EntityCollection\AlertCollection;

/**
 * Class Weather
 * @package philwc\DarkSky\Entity
 */
class Weather extends Entity
{
    /**
     * @var Longitude
     */
    private $longitude;

    /**
     * @var Latitude
     */
    private $latitude;

    /**
     * @var \DateTimeZone
     */
    private $timezone;

    /**
     * @var DataPoint
     */
    private $currently;

    /**
     * @var DataBlock
     */
    private $minutely;

    /**
     * @var DataBlock
     */
    private $hourly;

    /**
     * @var DataBlock
     */
    private $daily;

    /**
     * @var AlertCollection
     */
    private $alerts;

    /**
     * @var Flags
     */
    private $flags;

    /**
     * @param array $data
     * @return Weather
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     * @throws MissingDataException
     */
    public static function fromArray(array $data): Weather
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();

        $self->longitude = new Longitude($data['longitude']);
        $self->latitude = new Latitude($data['latitude']);
        $self->timezone = new \DateTimeZone($data['timezone']);

        if (array_key_exists('currently', $data)) {
            $data['currently']['timezone'] = $self->timezone;
            $self->currently = CurrentlyDataPoint::fromArray($data['currently']);
        }

        if (array_key_exists('minutely', $data)) {
            $data['minutely']['timezone'] = $self->timezone;
            $data['minutely']['collectionClass'] = MinutelyDataPointCollection::class;
            $data['minutely']['class'] = MinutelyDataPoint::class;
            $self->minutely = DataBlock::fromArray($data['minutely']);
        }

        if (array_key_exists('hourly', $data)) {
            $data['hourly']['timezone'] = $self->timezone;
            $data['hourly']['collectionClass'] = HourlyDataPointCollection::class;
            $data['hourly']['class'] = HourlyDataPoint::class;
            $self->hourly = DataBlock::fromArray($data['hourly']);
        }

        if (array_key_exists('daily', $data)) {
            $data['daily']['timezone'] = $self->timezone;
            $data['daily']['collectionClass'] = DailyDataPointCollection::class;
            $data['daily']['class'] = DailyDataPoint::class;
            $self->daily = DataBlock::fromArray($data['daily']);
        }

        if (array_key_exists('alerts', $data)) {
            $alertCollection = new AlertCollection();
            foreach ($data['alerts'] as $alert) {
                $alert['timezone'] = $self->timezone;
                $alertCollection->add(Alert::fromArray($alert));
            }
            $self->alerts = $alertCollection;
        }

        if (array_key_exists('flags', $data)) {
            $self->flags = Flags::fromArray($data['flags']);
        }

        return $self;
    }

    /**
     * @return array
     */
    protected static function getRequiredFields(): array
    {
        return [
            'longitude',
            'latitude',
            'timezone',
        ];
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude->toFloat();
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude->toFloat();
    }

    /**
     * @return \DateTimeZone
     */
    public function getTimezone(): \DateTimeZone
    {
        return $this->timezone;
    }

    /**
     * @return DataPoint
     */
    public function getCurrently(): ?DataPoint
    {
        return $this->currently;
    }

    /**
     * @return DataBlock
     */
    public function getMinutely(): ?DataBlock
    {
        return $this->minutely;
    }

    /**
     * @return DataBlock
     */
    public function getHourly(): ?DataBlock
    {
        return $this->hourly;
    }

    /**
     * @return DataBlock
     */
    public function getDaily(): ?DataBlock
    {
        return $this->daily;
    }

    /**
     * @return AlertCollection
     */
    public function getAlerts(): ?AlertCollection
    {
        return $this->alerts;
    }

    /**
     * @return Flags
     */
    public function getFlags(): ?Flags
    {
        return $this->flags;
    }
}

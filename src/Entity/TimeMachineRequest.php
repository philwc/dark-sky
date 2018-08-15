<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Value\Float\Latitude;
use philwc\DarkSky\Value\Float\Longitude;
use philwc\DarkSky\Value\OptionalParameters;

/**
 * Class TimeMachineRequest
 * @package philwc\DarkSky\Entity
 */
class TimeMachineRequest extends Request
{
    private const URI = 'https://api.darksky.net/forecast/%s/%s,%s,%s?%s';

    /**
     * @var \DateTimeImmutable
     */
    private $dateTime;

    /**
     * @param array $data
     * @return TimeMachineRequest
     * @throws \Assert\AssertionFailedException
     * @throws \philwc\DarkSky\Exception\MissingDataException
     * @throws \Exception
     */
    public static function fromArray(array $data): TimeMachineRequest
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();
        if ($data['longitude'] instanceof Longitude) {
            $self->longitude = $data['longitude'];
        } else {
            $self->longitude = new Longitude($data['longitude']);
        }

        if ($data['latitude'] instanceof Latitude) {
            $self->latitude = $data['latitude'];
        } else {
            $self->latitude = new Latitude($data['latitude']);
        }

        if ($data['datetime'] instanceof \DateTimeImmutable) {
            $self->dateTime = $data['datetime'];
        } else {
            $self->dateTime = new \DateTimeImmutable($data['datetime']);
        }

        if (array_key_exists('optionalParameters', $data)) {
            if ($data['optionalParameters'] instanceof OptionalParameters) {
                $self->optionalParameters = $data['optionalParameters'];
            } else {
                $self->optionalParameters = new OptionalParameters($data['optionalParameters']);
            }
        } else {
            $self->optionalParameters = new OptionalParameters();
        }

        if (array_key_exists('locationdescription', $data)) {
            $self->locationDescription = $data['locationdescription'];
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
            'datetime'
        ];
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateTime(): \DateTimeImmutable
    {
        return $this->dateTime;
    }

    /**
     * @param string $secretKey
     * @return string
     */
    public function getUri(string $secretKey): string
    {
        return sprintf(
            self::URI,
            $secretKey,
            $this->getLatitude()->toFloat(),
            $this->getLongitude()->toFloat(),
            $this->getDateTime()->format('U'),
            http_build_query([
                'lang' => $this->getOptionalParameters()->getLang()->toString(),
                'units' => $this->getOptionalParameters()->getUnits()->toString(),
            ])
        );
    }
}

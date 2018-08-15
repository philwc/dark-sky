<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Value\Float\Latitude;
use philwc\DarkSky\Value\Float\Longitude;
use philwc\DarkSky\Value\OptionalParameters;

/**
 * Class ForecastRequest
 * @package philwc\DarkSky\Entity
 */
class ForecastRequest extends Entity implements RequestInterface
{
    private const URI = 'https://api.darksky.net/forecast/%s/%s,%s?%s';

    /**
     * @var Latitude
     */
    private $latitude;

    /**
     * @var Longitude
     */
    private $longitude;

    /**
     * @var OptionalParameters
     */
    private $optionalParameters;

    /**
     * @param array $data
     * @return ForecastRequest
     * @throws \philwc\DarkSky\Exception\MissingDataException
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): ForecastRequest
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

        if (array_key_exists('parameters', $data)) {
            if ($data['parameters'] instanceof OptionalParameters) {
                $self->optionalParameters = $data['parameters'];
            } else {
                $self->optionalParameters = new OptionalParameters($data['parameters']);
            }
        } else {
            $self->optionalParameters = new OptionalParameters();
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
        ];
    }

    /**
     * @return Latitude
     */
    public function getLatitude(): Latitude
    {
        return $this->latitude;
    }

    /**
     * @return Longitude
     */
    public function getLongitude(): Longitude
    {
        return $this->longitude;
    }

    /**
     * @return OptionalParameters
     */
    public function getOptionalParameters(): OptionalParameters
    {
        return $this->optionalParameters;
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
            http_build_query([
                'lang' => $this->getOptionalParameters()->getLang()->toString(),
                'units' => $this->getOptionalParameters()->getUnits()->toString(),
            ])
        );
    }
}

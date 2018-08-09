<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\DateTimeHelper;
use philwc\DarkSky\Exception\InvalidDateFieldException;

/**
 * Class Alert
 * @package philwc\DarkSky\Entity
 */
class Alert extends Entity
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string[]
     */
    private $regions;

    /**
     * @var string
     */
    private $severity;

    /**
     * @var \DateTimeImmutable
     */
    private $time;

    /**
     * @var \DateTimeImmutable
     */
    private $expires;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $uri;

    /**
     * @return array
     */
    protected static function getRequiredFields(): array
    {
        return [
            'title',
            'regions',
            'severity',
            'time',
            'expires',
            'description',
            'uri'
        ];
    }

    /**
     * @param array $data
     * @return Alert
     * @throws \philwc\DarkSky\Exception\MissingDataException
     * @throws InvalidDateFieldException
     */
    public static function fromArray(array $data): Alert
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();

        $self->title = $data['title'];
        $self->regions = $data['regions'];
        $self->severity = $data['severity'];
        /** @var \DateTimeZone $timezone */
        $timezone = $data['timezone'];

        $self->time = DateTimeHelper::getDateTimeImmutable($data, 'time', $timezone);
        $self->expires = DateTimeHelper::getDateTimeImmutable($data, 'expires', $timezone);
        $self->description = $data['description'];
        $self->uri = $data['uri'];

        return $self;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string[]
     */
    public function getRegions(): array
    {
        return $this->regions;
    }

    /**
     * @return string
     */
    public function getSeverity(): string
    {
        return $this->severity;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getTime(): \DateTimeImmutable
    {
        return $this->time;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getExpires(): \DateTimeImmutable
    {
        return $this->expires;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}

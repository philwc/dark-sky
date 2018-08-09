<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\EntityCollection\EntityCollection;
use philwc\DarkSky\Value\Icon;
use philwc\DarkSky\EntityCollection\HourlyDataPointCollection;

/**
 * Class Period
 * @package philwc\DarkSky\Entity
 */
class DataBlock extends Entity
{
    /**
     * @var string
     */
    private $summary;
    /**
     * @var Icon
     */
    private $icon;
    /**
     * @var HourlyDataPointCollection
     */
    private $data;

    /**
     * @param array $data
     * @return DataBlock
     * @throws \philwc\DarkSky\Exception\MissingDataException
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): DataBlock
    {
        self::validate($data, self::getRequiredFields());

        $self = new self();

        if (array_key_exists('summary', $data)) {
            $self->summary = $data['summary'];
        }

        if (array_key_exists('icon', $data)) {
            $self->icon = new Icon($data['icon']);
        }

        $collectionClass = $data['collectionClass'];
        $class = $data['class'];

        /** @var EntityCollection $periodDataCollection */
        $periodDataCollection = new $collectionClass();
        foreach ($data['data'] as $dataItem) {
            $dataItem['timezone'] = $data['timezone'];
            $periodDataCollection->add($class::fromArray($dataItem));
        }
        $self->data = $periodDataCollection;

        return $self;
    }

    /**
     * @return array
     */
    protected static function getRequiredFields(): array
    {
        return [
            'data'
        ];
    }

    /**
     * @return string
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @return string
     */
    public function getIcon(): ?string
    {
        return $this->icon->toString();
    }

    /**
     * @return EntityCollection
     */
    public function getData(): EntityCollection
    {
        return $this->data;
    }
}

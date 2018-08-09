<?php
declare(strict_types=1);

namespace philwc\DarkSky\EntityCollection;

use philwc\DarkSky\Entity\EntityInterface;
use philwc\DarkSky\Entity\DataPoint;

/**
 * @package philwc\EntityCollection
 *
 * @method DataPoint\HourlyDataPoint add(EntityInterface $entity)
 * @method DataPoint\HourlyDataPoint last(): EntityInterface
 * @method DataPoint\HourlyDataPoint first(): EntityInterface
 * @method DataPoint\HourlyDataPoint offsetGet($offset): EntityInterface
 */
class HourlyDataPointCollection extends EntityCollection
{
    /**
     * @return string
     */
    protected function getCollectionClass(): string
    {
        return __CLASS__;
    }

    /**
     * @return string
     */
    protected function getEntityClass(): string
    {
        return DataPoint\HourlyDataPoint::class;
    }
}

<?php
declare(strict_types=1);

namespace philwc\DarkSky\EntityCollection;

use philwc\DarkSky\Entity\EntityInterface;
use philwc\DarkSky\Entity\DataPoint;

/**
 * @package philwc\EntityCollection
 *
 * @method DataPoint\DailyDataPoint add(EntityInterface $entity)
 * @method DataPoint\DailyDataPoint last(): EntityInterface
 * @method DataPoint\DailyDataPoint first(): EntityInterface
 * @method DataPoint\DailyDataPoint offsetGet($offset): EntityInterface
 */
class DailyDataPointCollection extends EntityCollection
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
        return DataPoint\DailyDataPoint::class;
    }
}

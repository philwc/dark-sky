<?php
declare(strict_types=1);

namespace philwc\DarkSky\EntityCollection;

use philwc\DarkSky\Entity\EntityInterface;
use philwc\DarkSky\Entity\DataPoint;

/**
 * @package philwc\EntityCollection
 *
 * @method DataPoint\MinutelyDataPoint add(EntityInterface $entity)
 * @method DataPoint\MinutelyDataPoint last(): EntityInterface
 * @method DataPoint\MinutelyDataPoint first(): EntityInterface
 * @method DataPoint\MinutelyDataPoint offsetGet($offset): EntityInterface
 */
class MinutelyDataPointCollection extends EntityCollection
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
        return DataPoint\MinutelyDataPoint::class;
    }
}

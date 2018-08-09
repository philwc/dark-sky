<?php
declare(strict_types=1);

namespace philwc\DarkSky\EntityCollection;

use philwc\DarkSky\Entity\Alert;
use philwc\DarkSky\Entity\EntityInterface;

/**
 * @package philwc\EntityCollection
 *
 * @method Alert add(EntityInterface $entity)
 * @method Alert last(): EntityInterface
 * @method Alert first(): EntityInterface
 * @method Alert offsetGet($offset): EntityInterface
 */
class AlertCollection extends EntityCollection
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
        return Alert::class;
    }
}

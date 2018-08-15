<?php
declare(strict_types=1);

namespace philwc\DarkSky\EntityCollection;

use philwc\DarkSky\Entity\RequestInterface;

/**
 * Class RequestCollection
 * @package philwc\DarkSky\EntityCollection
 */
class RequestCollection extends EntityCollection
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
        return RequestInterface::class;
    }
}

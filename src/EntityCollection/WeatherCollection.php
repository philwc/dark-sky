<?php
declare(strict_types=1);

namespace philwc\DarkSky\EntityCollection;

use philwc\DarkSky\Entity\Weather;

/**
 * Class WeatherCollection
 * @package philwc\DarkSky\EntityCollection
 */
class WeatherCollection extends EntityCollection
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
        return Weather::class;
    }
}

<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

/**
 * Interface EntityInterface
 * @package philwc\DarkSky\Entity
 */
interface EntityInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public static function fromArray(array $data);
}

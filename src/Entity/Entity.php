<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

use philwc\DarkSky\Exception\MissingDataException;

/**
 * Class Entity
 * @package philwc\DarkSky\Entity
 */
abstract class Entity implements EntityInterface
{
    /**
     * Entity constructor.
     * Use self::fromArray to construct
     */
    protected function __construct()
    {
        //noop
    }

    /**
     * @param array $data
     * @param array $requiredFields
     * @throws MissingDataException
     */
    protected static function validate(array $data, array $requiredFields): void
    {
        foreach ($requiredFields as $item) {
            if (!array_key_exists($item, $data)) {
                $e = new MissingDataException(
                    sprintf(
                        'Required field %s not found. Fields available: %s',
                        $item,
                        json_encode(array_keys($data))
                    )
                );
                $e->setAvailableFields(array_keys($data));
                throw $e;
            }
        }
    }
}

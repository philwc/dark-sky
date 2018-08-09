<?php
declare(strict_types=1);

namespace philwc\DarkSky\Exception;

/**
 * Class MissingDataException
 * @package philwc\DarkSky\Exception
 */
class MissingDataException extends DarkSkyException
{
    /**
     * @var array
     */
    private $availableFields;

    /**
     * @return array
     */
    public function getAvailableFields(): array
    {
        return $this->availableFields;
    }

    /**
     * @param array $availableFields
     */
    public function setAvailableFields(array $availableFields): void
    {
        $this->availableFields = $availableFields;
    }
}

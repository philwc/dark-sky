<?php
declare(strict_types=1);

namespace philwc\DarkSky\Entity;

/**
 * Interface RequestInterface
 * @package philwc\DarkSky\Entity
 */
interface RequestInterface
{
    /**
     * @param string $secretKey
     * @return string
     */
    public function getUri(string $secretKey): string;
}

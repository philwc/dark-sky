<?php
declare(strict_types=1);

namespace philwc\DarkSky\ClientAdapter;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface ClientAdapterInterface
 * @package philwc\DarkSky\ClientAdapter
 */
interface ClientAdapterInterface
{
    /**
     * @param $uri
     * @return ResponseInterface
     */
    public function get($uri): ResponseInterface;
}

<?php
declare(strict_types=1);

namespace philwc\DarkSky\ClientAdapter;

/**
 * Interface ClientAdapterInterface
 * @package philwc\DarkSky\ClientAdapter
 */
interface ClientAdapterInterface
{
    /**
     * @param callable $requests
     * @param callable $fulfulled
     * @param callable $rejected
     */
    public function getMulti(callable $requests, callable $fulfulled, callable $rejected): void;
}

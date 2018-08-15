<?php
declare(strict_types=1);

namespace philwc\DarkSky\ClientAdapter;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;

/**
 * Class GuzzleAdapter
 * @package philwc\DarkSky\ClientAdapter
 */
class GuzzleAdapter implements ClientAdapterInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * GuzzleAdapter constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param callable $requests
     * @param callable $fulfulled
     * @param callable $rejected
     * @return array|void
     */
    public function getMulti(callable $requests, callable $fulfulled, callable $rejected): void
    {
        $pool = new Pool($this->client, $requests(), [
            'concurrency' => 5,
            'fulfilled' => $fulfulled,
            'rejected' => $rejected,
        ]);

        $pool->promise()->wait();
    }
}

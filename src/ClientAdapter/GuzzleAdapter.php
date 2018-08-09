<?php
declare(strict_types=1);

namespace philwc\DarkSky\ClientAdapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use philwc\DarkSky\Exception\DarkSkyException;
use Psr\Http\Message\ResponseInterface;

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
     * @param $uri
     * @return ResponseInterface
     * @throws DarkSkyException
     */
    public function get($uri): ResponseInterface
    {
        try {
            return $this->client->request('GET', $uri);
        } catch (GuzzleException $e) {
            throw new DarkSkyException(
                'Error calling DarkSky forecast endpoint: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}

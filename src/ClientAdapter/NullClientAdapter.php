<?php
declare(strict_types=1);

namespace philwc\DarkSky\ClientAdapter;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class NullClientAdapter
 * @package philwc\DarkSky\ClientAdapter
 */
class NullClientAdapter implements ClientAdapterInterface
{
    /**
     * @var string
     */
    private $payload;

    /**
     * NullClientAdapter constructor.
     * @param string $payload
     */
    public function __construct(string $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @param $uri
     * @return ResponseInterface
     */
    public function get($uri): ResponseInterface
    {
        return new Response(200, [], $this->payload);
    }
}

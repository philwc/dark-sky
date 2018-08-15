<?php
declare(strict_types=1);

namespace philwc\DarkSky\ClientAdapter;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use philwc\DarkSky\Exception\DarkSkyException;
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
    private $payloads;

    /**
     * NullClientAdapter constructor.
     * @param array $payloads
     */
    public function __construct(array $payloads)
    {
        $this->payloads = $payloads;
    }

    /**
     * @param $key
     * @return ResponseInterface
     * @throws DarkSkyException
     */
    private function get($key): ResponseInterface
    {
        if (array_key_exists($key, $this->payloads)) {
            return new Response(200, [], $this->payloads[$key]);
        }
        throw  new DarkSkyException('Invalid key: ' . $key);
    }

    /**
     * @param callable $requests
     * @param callable $fulfulled
     * @param callable $rejected
     */
    public function getMulti(callable $requests, callable $fulfulled, callable $rejected):void
    {
        /** @var Request $request */
        foreach ($requests() as $key => $request) {
            try {
                $fulfulled($this->get($key), $key);
            } catch (DarkSkyException $e) {
                $rejected($e->getMessage(), $key);
            }
        }
    }
}

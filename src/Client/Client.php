<?php
declare(strict_types=1);

namespace philwc\DarkSky\Client;

use Assert\AssertionFailedException;
use GuzzleHttp\Psr7\Request;
use philwc\DarkSky\ClientAdapter\ClientAdapterInterface;
use philwc\DarkSky\Entity\ForecastRequest;
use philwc\DarkSky\Entity\RequestInterface;
use philwc\DarkSky\Entity\TimeMachineRequest;
use philwc\DarkSky\Entity\Weather;
use philwc\DarkSky\EntityCollection\RequestCollection;
use philwc\DarkSky\EntityCollection\WeatherCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class Client
 * @package philwc\DarkSky
 */
class Client implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var int
     */
    private $forecastTTL = 60;

    /**
     * @var int
     */
    private $timeMachineTTL = 86400;

    /**
     * @var string
     */
    private $secretKey;

    /**
     * @var ClientAdapterInterface
     */
    private $client;
    /**
     * @var null|CacheInterface
     */
    private $cache;

    /**
     * @var array
     */
    private $requestData = [];

    /**
     * @var WeatherCollection
     */
    private $weatherCollection;

    /**
     * Client constructor.
     * @param ClientAdapterInterface $client
     * @param string $secretKey
     * @param CacheInterface|null $cache
     */
    public function __construct(ClientAdapterInterface $client, string $secretKey, CacheInterface $cache = null)
    {
        $this->secretKey = $secretKey;
        $this->client = $client;
        $this->cache = $cache;
    }

    /**
     * @param int $forecastTTL
     */
    public function setForecastTTL(int $forecastTTL): void
    {
        $this->forecastTTL = $forecastTTL;
    }

    /**
     * @param int $timeMachineTTL
     */
    public function setTimeMachineTTL(int $timeMachineTTL): void
    {
        $this->timeMachineTTL = $timeMachineTTL;
    }

    /**
     * @param RequestInterface|RequestCollection $requests
     * @return Weather|WeatherCollection
     * @throws AssertionFailedException
     */
    public function retrieve($requests)
    {
        if ($requests instanceof RequestInterface) {
            $forecastRequestCollection = new RequestCollection();
            /** @noinspection PhpParamsInspection */
            $forecastRequestCollection->add($requests);

            return $this->retrieve($forecastRequestCollection)->first();
        }

        $this->requestData = [];
        $this->weatherCollection = new WeatherCollection();

        $this->client->getMulti(
            $this->getRequests($requests),
            $this->getFulfilled(),
            $this->getRejected()
        );

        return $this->weatherCollection;
    }

    /**
     * @param RequestCollection $requestCollection
     * @return callable
     */
    private function getRequests(RequestCollection $requestCollection): callable
    {
        return function () use ($requestCollection) {
            /** @var RequestInterface $request */
            foreach ($requestCollection as $request) {
                $uri = $request->getUri($this->secretKey);

                $cacheKey = $this->getCacheKey($uri);

                try {
                    if ($this->cache !== null && $this->cache->has($cacheKey)) {
                        $this->logger->debug('Retrieving uri data from cache');
                        $this->weatherCollection->add($this->getWeather($this->cache->get($cacheKey)));
                        continue;
                    }
                } catch (InvalidArgumentException $e) {
                    $this->logger->info('Cache Error: ' . $e->getMessage());
                }

                $this->logger->debug('Requesting ' . $uri);
                $this->requestData[] = [
                    'uri' => $uri,
                    'ttl' => $this->getTTL($request),
                ];

                yield new Request('GET', $uri);
            }
        };
    }

    /**
     * @return callable
     */
    private function getRejected(): callable
    {
        return function ($reason, $index) {
            $this->logger->error($index . ': ' . $reason);
        };
    }

    /**
     * @return callable
     */
    private function getFulfilled(): callable
    {
        return function (ResponseInterface $response, $index) {
            $data = json_decode($response->getBody()->getContents(), true);

            $cacheKey = false;
            $ttl = 0;
            if (array_key_exists($index, $this->requestData)) {
                $thisRequestData = $this->requestData[$index];
                $cacheKey = $this->getCacheKey($thisRequestData['uri']);
                $ttl = $thisRequestData['ttl'];
            }

            if ($this->cache !== null && $cacheKey !== false) {
                $this->logger->debug('Caching result for ' . $ttl . 's');
                try {
                    $this->cache->set($cacheKey, $data, $ttl);
                } catch (InvalidArgumentException $e) {
                    $this->logger->info('Cache error: ' . $e->getMessage());
                }
            }

            $this->weatherCollection->add($this->getWeather($data));
        };
    }

    /**
     * @param array $data
     * @return null|Weather
     */
    private function getWeather(array $data): ?Weather
    {
        try {
            return Weather::fromArray($data);
        } catch (\Exception $e) {
            $this->logger->error('Error validating weather data: ' . $e->getMessage());
            $this->logger->error($e->getTraceAsString());
            return null;
        } catch (AssertionFailedException $e) {
            $this->logger->error('Error validating weather data: ' . $e->getMessage());
            $this->logger->error($e->getTraceAsString());
            return null;
        }
    }

    /**
     * @param $uri
     * @return string
     */
    private function getCacheKey($uri): string
    {
        return sha1((string)$uri);
    }

    /**
     * @param RequestInterface $request
     * @return int
     */
    private function getTTL(RequestInterface $request): int
    {
        if ($request instanceof ForecastRequest) {
            return $this->forecastTTL;
        }

        if ($request instanceof TimeMachineRequest) {
            return $this->timeMachineTTL;
        }

        return 0;
    }
}

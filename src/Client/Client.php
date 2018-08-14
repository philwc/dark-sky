<?php
declare(strict_types=1);

namespace philwc\DarkSky\Client;

use Assert\AssertionFailedException;
use philwc\DarkSky\ClientAdapter\ClientAdapterInterface;
use philwc\DarkSky\Entity\Weather;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class Client
 * @package philwc\DarkSky
 */
abstract class Client implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var string
     */
    protected $secretKey;
    /**
     * @var ClientAdapterInterface
     */
    protected $client;
    /**
     * @var null|CacheInterface
     */
    private $cache;

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
     * @param string $uri
     * @param int $ttl
     * @return Weather
     */
    protected function makeCall(string $uri, int $ttl): ?Weather
    {
        $cacheKey = $this->getCacheKey($uri);

        try {
            if ($this->cache !== null && $this->cache->has($cacheKey)) {
                $this->logger->debug('Retrieving uri data from cache');
                return $this->getWeather($this->cache->get($cacheKey));
            }
        } catch (InvalidArgumentException $e) {
            $this->logger->info('Cache Error: ' . $e->getMessage());
        }

        $this->logger->debug('Calling ' . $uri);
        $response = $this->client->get($uri);
        $data = json_decode($response->getBody()->getContents(), true);

        if ($this->cache !== null) {
            $this->logger->debug('Caching result for ' . $ttl . 's');
            try {
                $this->cache->set($cacheKey, $data, $ttl);
            } catch (InvalidArgumentException $e) {
                $this->logger->info('Cache error: ' . $e->getMessage());
            }
        }

        return $this->getWeather($data);
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
            return null;
        } catch (AssertionFailedException $e) {
            $this->logger->error('Error validating weather data: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * @param $uri
     * @return string
     */
    private function getCacheKey($uri): string
    {
        return str_replace(['{', '}', '(', ')', '/', '\\', '@', ':'], '-', $uri);
    }
}

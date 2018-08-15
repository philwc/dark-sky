<?php
declare(strict_types=1);

namespace philwc\DarkSky;

use GuzzleHttp\Client as GuzzleClient;
use philwc\DarkSky\Client\Client;
use philwc\DarkSky\ClientAdapter\ClientAdapterInterface;
use philwc\DarkSky\ClientAdapter\GuzzleAdapter;
use philwc\DarkSky\ClientAdapter\SimpleAdapter;
use philwc\DarkSky\Client\Client as DarkSkyClient;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\SimpleCache\CacheInterface;

/**
 * Class ClientFactory
 * @package philwc\DarkSky
 */
class ClientFactory
{
    /**
     * @var LoggerInterface|null
     */
    private static $logger;

    /**
     * @param LoggerInterface $logger
     */
    public static function setLogger(LoggerInterface $logger): void
    {
        self::$logger = $logger;
    }

    /**
     * @param string $secretKey
     * @param CacheInterface|null $cache
     * @param ClientAdapterInterface|null $client
     * @return DarkSkyClient
     */
    public static function get(
        string $secretKey,
        CacheInterface $cache = null,
        ClientAdapterInterface $client = null
    ): DarkSkyClient
    {
        if ($client === null) {
            $client = self::getClient();
        }

        $darkskyClient = new Client($client, $secretKey, $cache);

        if (self::$logger === null) {
            self::$logger = new NullLogger();
        }

        $darkskyClient->setLogger(self::$logger);

        return $darkskyClient;
    }

    /**
     * @return ClientAdapterInterface
     */
    private static function getClient(): ClientAdapterInterface
    {
        /** @noinspection ClassConstantCanBeUsedInspection */
        if (class_exists('GuzzleHttp\Client', true)) {
            return new GuzzleAdapter(new GuzzleClient());
        }

        return new SimpleAdapter();
    }
}

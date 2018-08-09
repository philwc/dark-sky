<?php
declare(strict_types=1);

namespace philwc\DarkSky;

use GuzzleHttp\Client;
use philwc\DarkSky\Client\ForecastClient;
use philwc\DarkSky\Client\TimeMachineClient;
use philwc\DarkSky\ClientAdapter\ClientAdapterInterface;
use philwc\DarkSky\ClientAdapter\GuzzleAdapter;
use philwc\DarkSky\ClientAdapter\SimpleAdapter;
use philwc\DarkSky\Exception\InvalidClientException;
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

    public const FORECAST = 'forecast';
    public const TIME_MACHINE = 'time_machine';

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
     * @param string $type
     * @param string $secretKey
     * @param CacheInterface|null $cache
     * @param ClientAdapterInterface|null $client
     * @return ForecastClient|TimeMachineClient
     * @throws InvalidClientException
     */
    public static function get(
        string $type,
        string $secretKey,
        CacheInterface $cache = null,
        ClientAdapterInterface $client = null
    ): DarkSkyClient
    {
        if ($client === null) {
            $client = self::getClient();
        }

        $darkskyClient = false;
        if ($type === self::FORECAST) {
            $darkskyClient = new ForecastClient($client, $secretKey, $cache);
        }

        if ($type === self::TIME_MACHINE) {
            $darkskyClient = new TimeMachineClient($client, $secretKey, $cache);
        }

        if (!$darkskyClient) {
            throw new InvalidClientException(
                sprintf(
                    'Invalid client type specified (%s, %s available)',
                    self::FORECAST,
                    self::TIME_MACHINE
                )
            );
        }

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
            return new GuzzleAdapter(new Client());
        }

        return new SimpleAdapter();
    }
}

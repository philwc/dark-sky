# Dark Sky API Client

[![Build Status](https://travis-ci.org/philwc/dark-sky.svg?branch=master)](https://travis-ci.org/philwc/dark-sky)

This is a strongly typed simple client to talk to the Dark Sky API.

To get started, you will need to get a secret key from Dark Sky: https://darksky.net/dev/account.

This package makes use of HTTP adapters to connect to the API. Two are included out of the box,
a Guzzle adapter and a Simple adapter (using `file_get_contents`). If you have specialised
connection needs, simply implement the `ClientAdapterInterface` and pass to the client factory. 
If a ClientAdapter is not specified, the package will make use of the `GuzzleAdapter` if 
[Guzzle](http://guzzlephp.org/) is available, falling back to the `SimpleAdapter` (using `file_get_contents`)
if not.

This package is also able to make use of a PSR-16 caching adapter to cache calls from the API.
Simply pass a relevant cache service (see https://packagist.org/providers/psr/simple-cache-implementation) 
to the client factory to use. No caching is provided out of the box.

Finally, this is able to make use of a PSR-3 logger. Set your logger using `ClientFactory::setLogger($log);`.

This is all shown in the [Advanced Usage](#advanced-usage) section below.

## Usage

Install the package using composer:

```bash
composer require philwc/dark-sky
```

### Simple Usage

#### Forecast Client
To use the `ForecastClient` set `philwc\DarkSky\ClientFactory::FORECAST` on the `ClientFactory`:
 
```php
require_once __DIR__ . '/vendor/autoload.php';

$client = philwc\DarkSky\ClientFactory::get(
    philwc\DarkSky\ClientFactory::FORECAST, 
    getenv('SECRET_KEY')
);

$weather = $client->simpleRetrieve(53.4808, 2.2426);

echo $weather->getCurrently()->getSummary() . PHP_EOL; // Mostly Cloudy
echo $weather->getCurrently()->getIcon()->toString() . PHP_EOL; // partly-cloudy-day
```
#### Time Machine Client

To use the `TimeMachineClient` set  `philwc\DarkSky\ClientFactory::TIME_MACHINE` on the `ClientFactory`:

```php
$client = philwc\DarkSky\ClientFactory::get(
    philwc\DarkSky\ClientFactory::TIME_MACHINE, 
    getenv('SECRET_KEY')
);
```

The calls to `retrieve` and `simpleRetrieve` now require a timestamp:

```php
$weather = $client->simpleRetrieve(53.4808, 2.2426, 1514764800);
$weather = $client->retrieve(new Latitude(53.4808), new Longitude(2.2426), new DateTimeImmutable('2018-01-01 00:00:00'));
```

#### `simpleRetrieve` vs. `retrieve`

In addition to using the `simpleRetrieve` method on the client, 
you can use the `retrieve` method. This requires strict typing to validate 
your values. Internally, `simpleRetrieve` uses `retrieve`. This may be useful if
you want to handle invalid Latitude/Longitude further up in your code.

```php
$weather = $client->retrieve(new Latitude(53.4808), new Longitude(2.2426), new OptionalParameters(['units'=>'si', 'lang' => 'en']));

echo $weather->getCurrently()->getSummary() . PHP_EOL; // Mostly Cloudy
echo $weather->getCurrently()->getIcon()->toString() . PHP_EOL; // partly-cloudy-day
echo $weather->getCurrently()->getTemperature()->toFloat() . PHP_EOL; // 17.71
echo $weather->getCurrently()->getTemperature()->toString() . PHP_EOL; // 17.71 °C
``` 

### Advanced Usage
It is possible to pass both a PSR-16 cache adapter, as well as a PSR-3 logger into the `ClientFactory`

```php
require_once __DIR__ . '/vendor/autoload.php';

$log = new Monolog\Logger('test');
$log->pushHandler(new Monolog\Handler\ErrorLogHandler());

philwc\DarkSky\ClientFactory::setLogger($log);

$client = philwc\DarkSky\ClientFactory::get(
    philwc\DarkSky\ClientFactory::FORECAST, 
    getenv('SECRET_KEY'), 
    new Cache\Adapter\PHPArray\ArrayCachePool(), 
    new philwc\DarkSky\ClientAdapter\SimpleAdapter()
);
```

Once you have your client, you can pass in an array (for `simpleRetrieve`) or an instance of 
`OptionalParameters` (for `retrieve`) to customise the values you get back from DarkSky.

```php
$weather = $client->simpleRetrieve(53.4808, 2.2426, ['units'=>'si', 'lang' => 'en']);

echo $weather->getCurrently()->getSummary() . PHP_EOL; // Mostly Cloudy
echo $weather->getCurrently()->getIcon()->toString() . PHP_EOL; // partly-cloudy-day
echo $weather->getCurrently()->getTemperature()->toFloat() . PHP_EOL; // 17.71
echo $weather->getCurrently()->getTemperature()->toString() . PHP_EOL; // 17.71 °C

// This second call will now be retrieved from the cache
$weather = $client->simpleRetrieve(53.4808, 2.2426, ['units'=>'si', 'lang' => 'en']);

echo $weather->getCurrently()->getSummary() . PHP_EOL; // Mostly Cloudy
echo $weather->getCurrently()->getIcon()->toString() . PHP_EOL; // partly-cloudy-day
echo $weather->getCurrently()->getTemperature()->toFloat() . PHP_EOL; // 17.71
echo $weather->getCurrently()->getTemperature()->toString() . PHP_EOL; // 17.71 °C
```

### Caching

It is possible to set the TTL for the cache independently for each client. On the client, 
use `setTTL` to specify. By default, the following TTLs are set:

- `ForecastClient` - 60s
- `TimeMachineClient` - 86400s (24 hours)

```php
$client = philwc\DarkSky\ClientFactory::get(
    philwc\DarkSky\ClientFactory::FORECAST,
    getenv('SECRET_KEY'),
    new Cache\Adapter\PHPArray\ArrayCachePool()
);

$client->setTTL(120);

$weather = $client->simpleRetrieve(53.4808, 2.2426);

// This second call will now be cached for 120s
$weather = $client->simpleRetrieve(53.4808, 2.2426);
```

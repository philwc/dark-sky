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

If a guzzle adapter is provided (or the implemented `ClientAdapterInterface` supports it), multiple
requests will be made concurrently. 

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

####  Client
To use the `Client` use the `ClientFactory`:
 
```php
require_once __DIR__ . '/vendor/autoload.php';

$client = philwc\DarkSky\ClientFactory::get(
    getenv('SECRET_KEY')
);

$request = \philwc\DarkSky\Entity\ForecastRequest::fromArray([
    'latitude' => 53.4084,
    'longitude' => 2.9916,
]);

$weather = $client->retrieve($request);

echo $weather->getCurrently()->getSummary() . PHP_EOL; // Mostly Cloudy
echo $weather->getCurrently()->getIcon()->toString() . PHP_EOL; // partly-cloudy-day
echo $weather->getCurrently()->getTemperature()->toFloat() . PHP_EOL; // 17.71
echo $weather->getCurrently()->getTemperature()->toString() . PHP_EOL; // 17.71 °F
``` 

### Advanced Usage
It is possible to pass both a PSR-16 cache adapter, as well as a PSR-3 logger into the `ClientFactory`

```php
require_once __DIR__ . '/vendor/autoload.php';

$log = new Monolog\Logger('test');
$log->pushHandler(new Monolog\Handler\ErrorLogHandler());

philwc\DarkSky\ClientFactory::setLogger($log);

$client = philwc\DarkSky\ClientFactory::get(
    getenv('SECRET_KEY'), 
    new Cache\Adapter\PHPArray\ArrayCachePool(), 
    new philwc\DarkSky\ClientAdapter\GuzzleAdapter()
);
```

When creating your request, you can pass a `parameters` key 
to customise the values you get back from DarkSky.

```php
$request = \philwc\DarkSky\Entity\ForecastRequest::fromArray([
    'latitude' => 53.4084,
    'longitude' => 2.9916,
    'parameters' => ['lang' => 'en', 'units' => 'si']
]);
$weather = $client->retrieve($request);

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
use `setForecastTTL` or `setTimeMachineTTL` to specify. By default, the following TTLs are set:

- `ForecastClient` - 60s
- `TimeMachineClient` - 86400s (24 hours)

```php
$client = philwc\DarkSky\ClientFactory::get(
    getenv('SECRET_KEY'),
    new Cache\Adapter\PHPArray\ArrayCachePool()
);

$client->setForecastTTL(120);

$request = \philwc\DarkSky\Entity\ForecastRequest::fromArray([
    'latitude' => 53.4084,
    'longitude' => 2.9916,
]);

$weather = $client->retrieve($request);

// This second call will now be cached for 120s
$weather = $client->retrieve($request);
```

### Concurrent Requests

It is possible to make concurrent requests to the DarkSky API. Simply create a 
 `RequestCollection` and pass to `retrieve`
 
 ```php
 $client = philwc\DarkSky\ClientFactory::get(
     $secretKey,
     new Cache\Adapter\PHPArray\ArrayCachePool(),
     new philwc\DarkSky\ClientAdapter\SimpleAdapter()
 );
 
 $requestCollection = new \philwc\DarkSky\EntityCollection\RequestCollection();
 $manchesterRequest = \philwc\DarkSky\Entity\ForecastRequest::fromArray([
     'latitude' => 53.4808,
     'longitude' => 2.2426,
     'parameters' => ['lang' => 'en', 'units' => 'si']
 ]);
 
 $requestCollection->add($manchesterRequest);
 $liverpoolRequest = \philwc\DarkSky\Entity\ForecastRequest::fromArray([
     'latitude' => 53.4084,
     'longitude' => 2.9916,
     'parameters' => ['lang' => 'en', 'units' => 'si']
 ]);
 $requestCollection->add($liverpoolRequest);
 
 $weatherCollection = $client->retrieve($requestCollection);
 
 foreach ($weatherCollection as $weather) {
     echo $weather->getCurrently()->getSummary() . PHP_EOL;
     echo $weather->getCurrently()->getIcon()->toString() . PHP_EOL;
     echo $weather->getCurrently()->getTemperature()->toFloat() . PHP_EOL;
     echo $weather->getCurrently()->getTemperature()->toString() . PHP_EOL;
 }
 ```

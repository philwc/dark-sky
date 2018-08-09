# Dark Sky API Client

This is a simple client to talk to the Dark Sky API.

To get started, you will need to get a secret key from Dark Sky: https://darksky.net/dev/account.

This package makes use of HTTP adapters to connect to the API. Two are included out of the box,
a Guzzle adapter and a Simple adapter (using `file_get_contents`). If you have specialised
connection needs, simply implement the `ClientAdapterInterface` and pass to the client factory.

This package is also able to make use of a PSR-16 caching adapter to cache calls from the API.
Simply pass a relevant cache service (see https://packagist.org/providers/psr/simple-cache-implementation) 
to the client factory to use. No caching is provided out of the box.

Finally, this is able to make use of a PSR-3 logger. Set your logger using `ClientFactory::setLogger($log);`.

This is all shown in the Advanced Usage below.

## Usage

Install the package using composer:

```bash
composer require philwc/dark-sky
```

### Simple Usage
```php
require_once __DIR__ . '/vendor/autoload.php';

$client = philwc\DarkSky\ClientFactory::get(
    philwc\DarkSky\ClientFactory::FORECAST, 
    getenv('SECRET_KEY')
);

$weather = $client->simpleRetrieve(53.4808, 2.2426);

echo $weather->getCurrently()->getSummary() . PHP_EOL;
echo $weather->getCurrently()->getIcon()->toString() . PHP_EOL;
```

### Advanced Usage
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

$weather = $client->simpleRetrieve(53.4808, 2.2426);

echo $weather->getCurrently()->getSummary() . PHP_EOL;
echo $weather->getCurrently()->getIcon()->toString() . PHP_EOL;

// This second call will now be retrieved from the cache
$weather = $client->simpleRetrieve(53.4808, 2.2426);

echo $weather->getCurrently()->getSummary() . PHP_EOL;
echo $weather->getCurrently()->getIcon()->toString() . PHP_EOL;
```

In addition to using the `simpleRetrieve` method on the client, 
you can use the `retrieve` method. This requires strict typing to validate 
your values. Internally, `simpleRetrieve` uses `retrieve`.

```php
...
$weather = $client->retrieve(new Latitude(53.4808), new Longitude(2.2426));

echo $weather->getCurrently()->getSummary() . PHP_EOL;
echo $weather->getCurrently()->getIcon()->toString() . PHP_EOL;
``` 

Finally, to use the `TimeMachineClient` set the appropriate option on the `ClientFactory`

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
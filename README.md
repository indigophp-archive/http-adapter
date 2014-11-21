# Indigo HTTP Adapter

[![Latest Version](https://img.shields.io/github/release/indigophp/http-adapter.svg?style=flat-square)](https://github.com/indigophp/http-adapter/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/indigophp/http-adapter/develop.svg?style=flat-square)](https://travis-ci.org/indigophp/http-adapter)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/indigophp/http-adapter.svg?style=flat-square)](https://scrutinizer-ci.com/g/indigophp/http-adapter)
[![Quality Score](https://img.shields.io/scrutinizer/g/indigophp/http-adapter.svg?style=flat-square)](https://scrutinizer-ci.com/g/indigophp/http-adapter)
[![HHVM Status](https://img.shields.io/hhvm/indigophp/http-adapter.svg?style=flat-square)](http://hhvm.h4cc.de/package/indigophp/http-adapter)
[![Total Downloads](https://img.shields.io/packagist/dt/indigophp/http-adapter.svg?style=flat-square)](https://packagist.org/packages/indigophp/http-adapter)

**Provides adapters for common HTTP Client libraries.**


## Why an other HTTP library again?

The proposed HTTP Message [PSR](https://github.com/php-fig/fig-standards/blob/master/proposed/http-message.md) is going to be great....but that won't let anyone create HTTP Client agnostic packages. For example you cannot typehint for a `ClientInterface`. You can only operate on the same messages. The PSR Meta also mentions adapter packages as a valid approach. There are many cool adapter packages out there, but all of them implement a simple logic based on the author's need. You can consider this package as a simple `Adapter` providing you full control over the common fetures of the implemented HTTP Client libraries. However, it must be noted that the specific features are out of scope. For example: if you need to use Guzzle specific feature, depend on it instead.

This package also provides a simple implementation of the latest PSR interfaces.


## Install

Via Composer

``` bash
$ composer require indigophp/http-adapter
```


## Usage

### Simple usage

You are free to directly use any adapters in your application.

``` php
use Indigo\Http\Adapter;

class MyAdapterAware
{
    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function get()
    {
        $request = new Request;
        $request->setUrl('http://foo.com');

        return $this->adapter->send($request);
    }
}
```

You can also use the client class for the most common client usage. (Guzzle is only used as an example)

``` php
use GuzzleHttp\Client as GuzzleClient;
use Indigo\Http\Adapter\Guzzle4;
use Indigo\Http\Client;

$adapter = new Guzzle4(new GuzzleClient);
$client = new Client($adapter);

$client->get('http://foo.com');
```


### Advanced usage

For testing you can use the `Mock` adapter.

``` php
use Indigo\Http\Adapter\Mock;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// ... your testing logic

// you can directly pass the Response object to the constructor
$adapter = new Mock(function(Request $request) {
    return new Response;
});

// Optionally
$adapter->setResponse(new Response);

// ... your testing logic
```

You can decorate your adapters with various decorators.

#### Event decorator

Event decorator emitts two events:

- Before (request)
- Complete (response)

Both events receive the `Adapter` and the `Request`. The `Complete` event contains the `Response` as well.

``` php
use Indigo\Http\Adapter\Event;
use Indigo\Http\Event;

$adapter = new Event($decoratedAdapter);

// Optionally
// $adapter->setEmitter($emitter);

$adapter->addListener('before', function(Event\Before $event) {
    $adapter = $event->getAdapter();
    $request = $event->getRequest();

    // ... do something with the adapter and the request
});

$adapter->addListener('complete', function(Event\Complete $event) {
    $adapter = $event->getAdapter();
    $request = $event->getRequest();
    $response = $event->getResponse();

    // ... do something with the adapter, request and the response
});
```

You can also use `Subscriber`s with the `Event` adapter.

``` php
use Indigo\Http\Adapter\Event;
use Indigo\Http\Subscriber\Auth;

$adapter = new Event($decoratedAdapter);

// This will always attach authentication data to your requests
$adapter->addSubscriber(new Auth('username', 'password', Auth::BASIC));
```

Currently [league/event](http://event.thephpleague.com) is used as event backend.


#### Cache decorator

You can use a local cache for returned `Response`s. Based on cached items you can send `Request`s to the server with `If-Modified-Since` and `If-None-Match` (`ETag` header required in response) headers. If the server return with 304 status then the cached item is returned, otherwise it gets cached for future.

``` php
use Indigo\Http\Adapter\Cache;

$adapter = new Cache($decoratedAdapter);

// Optionally
// $adapter->setPool($pool);

// Status: 200 OK
$response = $adapter->send($request);

// Status: 304 Not Modified
// Returned from cache
$response = $adapter->send($request);
```

Currently [Stash](http://stashphp.com) is used as cache backend.


### Exceptions

There are two main type of exceptions:

- `AdapterException`: Thrown when some sort of adapter problem occurs.
- `RequestException`: Thrown if the response itself is an error response (4xx, 5xx) or the request cannot be completed (no response returned).


## Testing

``` bash
$ phpspec run
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/indigophp/http-adapter/contributors)


## Inspired by

- Guzzle
- fXmlRpc


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

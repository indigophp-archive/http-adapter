# Indigo HTTP Adapter

[![Build Status](https://img.shields.io/travis/indigophp/http-adapter/develop.svg?style=flat-square)](https://travis-ci.org/indigophp/http-adapter)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/indigophp/http-adapter.svg?style=flat-square)](https://scrutinizer-ci.com/g/indigophp/http-adapter)
[![Packagist Version](https://img.shields.io/packagist/v/indigophp/http-adapter.svg?style=flat-square)](https://packagist.org/packages/indigophp/http-adapter)
[![Total Downloads](https://img.shields.io/packagist/dt/indigophp/http-adapter.svg?style=flat-square)](https://packagist.org/packages/indigophp/http-adapter)
[![Quality Score](https://img.shields.io/scrutinizer/g/indigophp/http-adapter.svg?style=flat-square)](https://scrutinizer-ci.com/g/indigophp/http-adapter)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

**Provides adapters for common HTTP Client libraries.**


## Why an other HTTP library again?

The proposed HTTP Message [PSR](https://github.com/php-fig/fig-standards/blob/master/proposed/http-message.md) is going to be great....but that won't let anyone create HTTP Client agnostic packages. For example you cannot typehint for a `ClientInterface`. You can only operate on the same messages. The PSR Meta also mentions adapter packages as a valid approach. There are many cool adapter packages out there, but all of them implement a simple logic based on the author's need. You can consider this package as a simple `Adapter` providing you full control over the common fetures of the implemented HTTP Client libraries. However, it must be noted that the specific features are out of scope. For example: if you need to use Guzzle specific feature, depend on it instead.

This package also provides a simple implementation of the latest PSR interfaces.


## Install

Via Composer

``` json
{
    "require": {
        "indigophp/http-adapter": "@stable"
    }
}
```


## Usage




## Testing

``` bash
$ codecept run
```


## Contributing

Please see [CONTRIBUTING](https://github.com/indigophp/http-adapter/blob/develop/CONTRIBUTING.md) for details.


## Credits

- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/indigophp/http-adapter/contributors)


## Inspired by

- Guzzle
- fXmlRpc


## License

The MIT License (MIT). Please see [License File](https://github.com/indigophp/http-adapter/blob/develop/LICENSE) for more information.

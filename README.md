# Parameter Bag

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A flexible parameter bag in place of standard arrays on PHP classes


## Install

Via Composer

```bash
$ composer require juststeveking/parameterbag
```

## Usage

Basic usage. Create a parameter bag from a simple array.

```php
$parameters = ['foo' => 'bar'];
$bag = new \JustSteveKing\ParameterBag($parameters);
```


Create a parameter bag from a query string, please note by default the delimeter is `&` but this can be overridden as the second arguement should you want to use another method.

```php
$query = \JustSteveKing\ParameterBag::fromString($request->getQuery());
```


A more useful example:

```php
class Config
{
    protected ParameterBag $items;

    private function __construct(array $items)
    {
        $this->items = new ParameterBag($items);
    }

    public static function create(array $items) : self
    {
        return new self($items);
    }
}
```


[ico-version]: https://img.shields.io/packagist/v/juststeveking/parameterbag.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/juststeveking/parameterbag.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/JustSteveKing/parameterbag.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/JustSteveKing/parameterbag.svg?style=flat-square

[link-scrutinizer]: https://scrutinizer-ci.com/g/JustSteveKing/parameterbag/code-structure
[link-packagist]: https://packagist.org/packages/juststeveking/parameterbag
[link-downloads]: https://packagist.org/packages/juststeveking/parameterbag
[link-author]: https://github.com/JustSteveKing
[link-code-quality]: https://scrutinizer-ci.com/g/JustSteveKing/parameterbag
# Analyze the relations on a given Laravel model

![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/plank/larelations?color=%234ccd98&label=php&logo=php&logoColor=%23fff)
![Laravel Version Support](https://img.shields.io/badge/laravel-9.x,%2010.x-%2343d399?logo=laravel&logoColor=%23ffffff)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/plank/larelations.svg?color=%234ccd98&style=flat-square)](https://packagist.org/packages/plank/larelations)
[![Total Downloads](https://img.shields.io/packagist/dt/plank/larelations.svg?color=%234ccd98&style=flat-square)](https://packagist.org/packages/plank/larelations)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/plank/larelations/test.yml?branch=main&&color=%234ccd98&label=run-tests&logo=github&logoColor=%23fff)](https://github.com/plank/larelations/actions?query=workflow%3Arun-tests)
[![Code Climate coverage](https://img.shields.io/codeclimate/coverage/plank/larelations?color=%234ccd98&label=test%20coverage&logo=code-climate&logoColor=%23fff)](https://codeclimate.com/github/plank/larelations/test_coverage)
[![Code Climate maintainability](https://img.shields.io/codeclimate/maintainability/plank/larelations?color=%234ccd98&label=maintainablility&logo=code-climate&logoColor=%23fff)](https://codeclimate.com/github/plank/larelations/maintainability)

This package is designed to extract all of the Relations from a given Model using reflection and parsing the code.

## Support us

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://plank.co/about-us). We publish all received postcards on [our virtual postcard wall](https://plank.co/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require plank/larelations
```

## Usage

```php
$extractor = new Plank\Larelations\RelationExtractor();
$relations = $extractor->extract($post);
$relations = Larelations::extract(Post::class);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Kurt Friars](https://github.com/kfriars)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

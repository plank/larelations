# Larelations

![Laravel Version Support](https://img.shields.io/badge/laravel-9.x,%2010.x-%232c1e8f?logo=laravel&logoColor=%23fff)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/plank/larelations/run-tests.yml?branch=main&&color=%232c1e8f&label=run-tests&logo=github&logoColor=%23fff)](https://github.com/plank/larelations/actions?query=workflow%3Arun-tests)
[![Code Climate coverage](https://img.shields.io/codeclimate/coverage/plank/larelations?color=%232c1e8f&label=test%20coverage&logo=code-climate&logoColor=%23fff)](https://codeclimate.com/github/plank/larelations/test_coverage)
[![Code Climate maintainability](https://img.shields.io/codeclimate/maintainability/plank/larelations?color=%232c1e8f&label=maintainablility&logo=code-climate&logoColor=%23fff)](https://codeclimate.com/github/plank/larelations/maintainability)

This package is designed to extract Eloquent Relations from a given Model using reflection and return type checking.

## Installation

You can install the package via composer:

```bash
composer require plank/larelations
```

## Usage

Given an instance of an Eloquent Model or its class-string, this package will extract all relations defined on the model, and return them in a Collection of `RelationInstance` items.

Each `RelationInstance` has the ReflectionMethod (`$method`) where the relation was defined, as well as an instance of the `Relation` ($relation). There are some helper methods on the `RelationInstance` that allow you to classify the type relation it is (ie. child, parent, pivotted, etc).

```php
$extractor = new \Plank\Larelations\Extractor();
$instances = $extractor->extract($post);
$instances = \Plank\Larelations\Facades\Larelations::extract(Post::class);

foreach ($instances as $instance) {
    if ($instance->isChild()) {
        // Handle child types of relations
    }

    if ($instance->relation instanceof \Znck\Eloquent\Traits\BelongsToThrough) {
        // Handle custom relation
    }

    // The method property is the \ReflectionMethod of the relation instance
    $instance->method->getName(); // posts
}
```

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Kurt Friars](https://github.com/kfriars)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Security Vulnerabilities

If you discover a security vulnerability within Larelations, please send an e-mail to security@plankdesign.com. All security vulnerabilities will be promptly addressed.

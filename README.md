<div align="left">
    <a href="https://tilto.nl">
      <picture>
        <img alt="Cover" src="/cover.webp">
      </picture>
    </a>

<br />
<br />

[![Latest Version on Packagist](https://img.shields.io/packagist/v/businesstilto/commentable.svg?style=for-the-badge)](https://packagist.org/packages/businesstilto/commentable)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=for-the-badge)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/businesstilto/commentable.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/businesstilto/commentable)
[![Total Downloads](https://img.shields.io/packagist/dt/businesstilto/commentable.svg?style=for-the-badge)](https://packagist.org/packages/businesstilto/commentable)
    
</div>

A lightweight and easy to use package that adds commenting in Filament v4.5 and newer.

Inspired by and built upon code from the [Kirschbaum Commentions package](https://github.com/kirschbaum-development/commentions), but takes a different approach to commenting in Filament.

## Installation

You can install the package via composer:

```bash
composer require businesstilto/commentable
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="commentable-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="commentable-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="commentable-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$commentable = new Tilto\Commentable();
echo $commentable->echoPhrase('Hello, Tilto!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tilto](https://github.com/businesstilto)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

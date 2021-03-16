# Searchable Dropdown Description

[![Latest Version on Packagist](https://img.shields.io/packagist/v/teofanis/searchable-dropdown.svg?style=flat-square)](https://packagist.org/packages/teofanis/searchable-dropdown)
[![Build Status](https://img.shields.io/travis/teofanis/searchable-dropdown/master.svg?style=flat-square)](https://travis-ci.org/teofanis/searchable-dropdown)
[![Quality Score](https://img.shields.io/scrutinizer/g/teofanis/searchable-dropdown.svg?style=flat-square)](https://scrutinizer-ci.com/g/teofanis/searchable-dropdown)
[![Total Downloads](https://img.shields.io/packagist/dt/teofanis/searchable-dropdown.svg?style=flat-square)](https://packagist.org/packages/teofanis/searchable-dropdown)

Searchable dropdown is a dropdown component built with Alpine JS and blade components. 
It can be used as a normal dropdown or a multiple selection dropdown.

## Installation

You can install the package via composer:

```bash
composer require teofanis/searchable-dropdown
```
Publish the dropdowns' config and asset files
```bash
php artisan vendor:publish --tag=searchable-dropdown-config
php artisan vendor:publish --tag=searchable-dropdown-assets
```
Finally add the dropdown styles and scripts in the head section of your layout file.  
```bash
@searchableDropdownStyles
@searchableDropdownScripts
```;

## Usage

``` php
// Usage description here
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email teos_97@hotmail.com instead of using the issue tracker.

## Credits

- [Teofanis Papadopulos](https://github.com/teofanis)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

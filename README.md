# Field

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Field is a blueprint to work as a CMS inspired on [cockpit](http://getcockpit.com/).
Via command line you can create fields for your partials and consume in your project using Repository, Services or Extensions.

## Features
- Mult language database schema
- Collection of fields
- Options of fields
- CLI interface
- Services, Repositories and Storage
- [Doctrine](https://github.com/doctrine/doctrine2) and [Relational](https://github.com/Respect/Relational) suport (cli only work with relational see issue #27)

### Example

You can create Languages, Collections, Fields and Options. Here some examples:
```bash
php vendor/bin/field create Language en_EN English

php vendor/bin/field create Collection header Header en_EN

php vendor/bin/field create Field about "About text" en_EN html
php vendor/bin/field create Field meta-keys Metakeys en_EN text header
php vendor/bin/field create Field contact Contact en_EN text

php vendor/bin/field create Option Girl contact en_EN
php vendor/bin/field create Option Boy contact en_EN

```

Now you can use some repository or services to consume, or implement the storage as you need and white you own repository and services.
Example!
```php
use WilliamEspindola\Field\Storage\ORM\Doctrine;
use WilliamEspindola\Field\Repository\FieldRepository;

$doctrineStorage    = new Doctrine(/** doctrine setup */); // you can uss orther ORM as you want
$repository         = new FieldRepository($doctrineStorage);

$repository->findAll()
```
[Checkout the docs on wiki!](https://github.com/williamespindola/field/wiki)

## Install

Via Composer

``` bash
$ composer require williamespindola/field
```

## Usage

``` bash
php vendor/bin/field
```

See all documentation on [Wiki](https://github.com/williamespindola/field/wiki)

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email oi@williamespindola.com.br instead of using the issue tracker.

## Credits

- [William Espindola][link-author]
- [All Contributors][link-contributors]

## License

The BSD License (BSD). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/williamespindola/field.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-BSD-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/williamespindola/field/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/williamespindola/field.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/williamespindola/field.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/williamespindola/field.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/williamespindola/field
[link-travis]: https://travis-ci.org/williamespindola/field
[link-scrutinizer]: https://scrutinizer-ci.com/g/williamespindola/field/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/williamespindola/field
[link-downloads]: https://packagist.org/packages/williamespindola/field
[link-author]: https://github.com/williamespindola
[link-contributors]: ../../contributors

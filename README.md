# oxid-esales/graphql-storefront

[![Build Status](https://img.shields.io/github/workflow/status/OXID-eSales/graphql-storefront-module/CI?logo=github-actions&style=for-the-badge)](https://github.com/OXID-eSales/graphql-storefront-module/actions)

[![Latest Version](https://img.shields.io/packagist/v/OXID-eSales/graphql-storefront?logo=composer&label=latest&include_prereleases&color=orange)](https://packagist.org/packages/oxid-esales/graphql-storefront)
[![PHP Version](https://img.shields.io/packagist/php-v/oxid-esales/graphql-storefront)](https://github.com/oxid-esales/graphql-storefront-module)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_graphql-storefront-module&metric=alert_status)](https://sonarcloud.io/dashboard?id=OXID-eSales_graphql-storefront-module)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_graphql-storefront-module&metric=coverage)](https://sonarcloud.io/dashboard?id=OXID-eSales_graphql-storefront-module)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_graphql-storefront-module&metric=sqale_index)](https://sonarcloud.io/dashboard?id=OXID-eSales_graphql-storefront-module)

This module provides [GraphQL](https://www.graphql.org) queries and mutations for the [OXID eShop](https://www.oxid-esales.com/) storefront.

## Usage

This assumes you have OXID eShop (at least `oxid-esales/oxideshop_ce: v6.5.0` component, which is part of the `v6.2.0` compilation) up and running.

### Install

```bash
$ composer require oxid-esales/graphql-storefront

$ ./bin/oe-console oe:module:install-configuration ./vendor/oxid-esales/graphql-base
$ ./bin/oe-console oe:module:install-configuration ./vendor/oxid-esales/graphql-storefront

$ vendor/bin/oe-eshop-doctrine_migration migration:migrate oe_graphql_storefront
```

If you didn't have the `oxid-esales/graphql-base` module installed, composer will do that for you.

After installing the module, you need to activate it, either via OXID eShop admin or CLI.

```bash
$ ./bin/oe-console oe:module:activate oe_graphql_base
$ ./bin/oe-console oe:module:activate oe_graphql_storefront
```

## Branch Compatibility

* master branch is compatible with OXID eShop compilation master (which uses `graphql-base` master branch)
* b-6.x branch is compatible with OXID eShop compilation b-6.x (which uses `graphql-base` b-6.x branch)

### How to use

A good starting point is to check the [How to use section in the GraphQL Base Module](https://github.com/OXID-eSales/graphql-base-module/#how-to-use)

## Testing

### Linting, syntax check, static analysis and unit tests

```bash
$ composer test
```

### Integration/Acceptance tests

- install this module into a running OXID eShop
- change the `test_config.yml`
  - add `oe/graphql-base,oe/graphql-storefront` to the `partial_module_paths`
  - set `activate_all_modules` to `true`
- `composer require codeception/module-rest --dev`
- `composer require codeception/module-phpbrowser --dev`
- `composer require codeception/module-db --dev`

```bash
$ ./vendor/bin/runtests
$ ./vendor/bin/runtests-codeception
```

## Contributing

You like to contribute? 🙌 AWESOME 🙌\
Go and check the [contribution guidelines](CONTRIBUTING.md)

## Build with

- [GraphQLite](https://graphqlite.thecodingmachine.io/)

## License

GPLv3, see [LICENSE file](LICENSE).

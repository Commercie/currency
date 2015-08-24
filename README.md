Currency
========

# Introduction
A library that provides metadata for current and historic currencies:
* ISO 4217 currency codes and numbers
* Currency signs, both official and unofficial
* The number of decimals a currency has
* Where (ISO 3166 country codes) and when (ISO 8601 dates) currencies were and
  are used
* Fixed exchange rates (usually historic)

# Usage
* Currencies can be loaded through `\BartFeenstra\Currency\ResourceRepository`.
* `\BartFeenstra\Currency\InputInterface` is capable of parsing user-input numbers.

# Requirements
The library does not have any global requirements.

## Testing
* PHPUnit 3.7.*

## PHP
* PHP 5.3.x or higher

# Integrates with
* [Composer](http://getcomposer.org) (as
[bartfeenstra/currency](https://packagist.org/packages/bartfeenstra/currency))
* [Drupal](http://drupal.org) (through [Currency](http://drupal.org/project/currency))

Currency
========

# Introduction
A PHP library that provides metadata for current and historic currencies:
* ISO 4217 currency codes and numbers
* Currency signs
* The number of decimals a currency has
* Where (ISO 3166 country codes) and when (ISO 8601 dates) currencies were and
  are used

# Usage
The class `CurrencyController` is the central CRUD controller. Predefined
currencies are stored as YAML files in /config/currencies/predefined. You can
put your own YAML files in /config/currencies/custom. If predefined currencies
with the same ISO 4217 code exist, custom ones will override them.

# Requirements
* PHP 5.3.x or higher
* Symfony YAML 2.1.*
* PHPUnit 3.7.* (for running tests only)

# Integrates with
* [Composer](http://getcomposer.org) (as
[bartfeenstra/currency](https://packagist.org/packages/bartfeenstra/currency))
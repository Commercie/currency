Currency
========

# Introduction
A language-independent library that provides metadata for current and historic
currencies:
* ISO 4217 currency codes and numbers
* Currency signs
* The number of decimals a currency has
* Where (ISO 3166 country codes) and when (ISO 8601 dates) currencies were and
  are used
* Fixed exchange rates (usually historic)

# Usage
Currency information is stored in YAML files in /config. The PHP class
`CurrencyController` is the central CRUD controller which servers as a helper
for handling the currency information, but it is not required to make use of
the library.

# Requirements
* Any YAML parser.
* PHPUnit 3.7.* (for running tests only)

# Suggested packages
* PHP 5.3.x or higher
* Symfony YAML 2.1.*

# Integrates with
* [Composer](http://getcomposer.org) (as
[bartfeenstra/currency](https://packagist.org/packages/bartfeenstra/currency))
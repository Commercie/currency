<?php

/**
 * @file
 * Contains class HistoricalProvider.
 */

namespace BartFeenstra\Currency\Conversion;

use BartFeenstra\Currency\Conversion\ProviderInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Provides exchange rates for historical currencies.
 */
class HistoricalProvider implements ProviderInterface {

  /**
   * Definitions of exchanges rates.
   *
   * @see self::processRates()
   *
   * @var array
   *   Keys are ISO 4217 currency codes of source currencies, values are
   *   arrays, of which the keys are ISO 4217 codes of destination currencies,
   *   and of which values are the exchange rates. Because the rate XXX:YYY is
   *   the same as 1/YYY:XXX, any missing rates will automatically be
   *   calculated.
   */
  private static $rates = NULL;

  /**
   * Implements ProviderInterface::rate().
   */
  static function rate($currency_code_source, $currency_code_destination) {
    self::processRates();

    if (isset(self::$rates[$currency_code_source]) && isset(self::$rates[$currency_code_source][$currency_code_destination])) {
      return self::$rates[$currency_code_source][$currency_code_destination];
    }
    return FALSE;
  }

  /**
   * Processes the exchange rate definitions.
   *
   * @return NULL
   */
  private static function processRates() {
    if (is_null(self::$rates)) {
      self::$rates = Yaml::parse(file_get_contents(__DIR__ . '/../../../../config/FixedConversionRates.yaml'));
      $rates_original = self::$rates;
      foreach ($rates_original as $currency_code_from => $currency_from_rates) {
        foreach ($currency_from_rates as $currency_code_to => $rate) {
          if (!isset(self::$rates[$currency_code_to]) || !isset(self::$rates[$currency_code_to][$currency_code_from])) {
            self::$rates[$currency_code_to][$currency_code_from] = 1 / $rate;
          }
        }
      }
      $processed = TRUE;
    }
  }
}

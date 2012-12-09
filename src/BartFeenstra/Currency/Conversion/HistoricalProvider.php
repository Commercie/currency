<?php

/**
 * @file
 * Contains class HistoricalProvider.
 */

namespace BartFeenstra\Currency\Conversion;

use BartFeenstra\Currency\Conversion\ProviderInterface;

/**
 * Provides exchange rates for historical currencies.
 */
class HistoricalProvider implements ProviderInterface {

  /**
   * Definitions of exchanges rates.
   *
   * @see self::historicalRates()
   *
   * @var array
   *   Keys are ISO 4217 currency codes of source currencies, values are
   *   arrays, of which the keys are ISO 4217 codes of destination currencies,
   *   and of which values are the exchange rates. Because the rate XXX:YYY is
   *   the same as 1/YYY:XXX, we only keep one rate here for every combination
   *   of two currencies. For every combination, we keep the rate from the
   *   currency of which the code comes first when sorting alphabetically, e.g.
   *   we keep a rate for EUR:NLG and UAH:UAK, but not for NLG:EUR and UAK:UAH.
   */
  private static $rates = array(
    'EUR' => array(
      'LVL' => 0,702804,
      'LTL' => 3,45280,
      'NLG' => 2.20371,
    ),
    'UAH' => array(
      'UAK' => 100000,
    ),
  );

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
    static $processed = FALSE;

    if (!$processed) {
      $rates_original = self::$rates;
      foreach ($rates_original as $currency_code_from => $currency_from_rates) {
        foreach ($currency_from_rates as $currency_code_to => $rate) {
          self::$rates[$currency_code_to][$currency_code_from] = 1 / $rate;
        }
      }
      $processed = TRUE;
    }
  }
}

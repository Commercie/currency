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
   *   the same as 1/YYY:XXX, any missing rates will automatically be
   *   calculated.
   */
  private static $rates = array(
    'BGN' => array(
      'BGL' => 1000,
    ),
    'BRB' => array(
      'BRZ' => 1000,
    ),
    'BRC' => array(
      'BRB' => 1000,
    ),
    'BRE' => array(
      'BRN' => 1,
    ),
    'BRL' => array(
      'BRR' => 2750,
    ),
    'BRN' => array(
      'BRC' => 1000,
    ),
    'BRR' => array(
      'BRE' => 1000,
    ),
    'CAD' => array(
      'NFD' => 1,
    ),
    'CLP' => array(
      'CLE' => 1000,
    ),
    'EUR' => array(
      'ATS' => 13.7603,
      'BEF' => 40.3399,
      'CYP' => 0.585274,
      'DEM' => 1.95583,
      'EEK' => 15.6466,
      'ESP' => 166.386,
      'FIM' => 5.94573,
      'FRF' => 6.55957,
      'GRD' => 340.75,
      'IEP' => 0.787564,
      'ITL' => 1.93627,
      'LUF' => 40.3399,
      'LVL' => 0.702804,
      'LTL' => 3.45280,
      'MCF' => 6.55957,
      'MTL' => 0.4293,
      'NLG' => 2.20371,
      'PTE' => 200.482,
      'SIT' => 239.64,
      'SKK' => 30.126,
      'SML' => 1.93627,
      'VAL' => 1.93627,
    ),
    'ILS' => array(
      'ILR' => 1000,
    ),
    'ISK' => array(
      'ISJ' => 100,
    ),
    'KGS' => array(
      'SUR' => 200,
    ),
    'MGA' => array(
      'MGF' => 5,
    ),
    'PEI' => array(
      'PEH' => 1000,
    ),
    'PEN' => array(
      'PEI' => 1000000,
    ),
    'PLN' => array(
      'PLZ' => 10000,
    ),
    'RON' => array(
      'ROL' => 10000,
    ),
    'RUB' => array(
      'SUR' => 1000,
      'RUR' => 1000,
    ),
    'SDD' => array(
      'SDP' => 10,
    ),
    'SDG' => array(
      'SDD' => 100,
    ),
    'TJS' => array(
      'TJR' => 1000,
    ),
    'TRY' => array(
      'TRL' => 1000000,
    ),
    'UAH' => array(
      'UAK' => 100000,
    ),
    'UGX' => array(
      'UGS' => 100,
    ),
    'USD' => array(
      'ECS' => 25000,
    ),
    'UYU' => array(
      'UYN' => 1000,
    ),
    'VEF' => array(
      'VEB' => 1000,
    ),
    'YUR' => array(
      'YUN' => 10,
    ),
    'YUO' => array(
      'YUR' => 1000000,
    ),
    'YUG' => array(
      'YUO' => 1000000000,
    ),
    'ZRN' => array(
      'ZRZ' => 3000000,
    ),
    'ZWD' => array(
      'ZWC' => 1,
    ),
    'ZWN' => array(
      'ZWD' => 1000,
    ),
    'ZWR' => array(
      'ZWN' => 10000000000,
    ),
    'ZWL' => array(
      'ZWR' => 1000000000000,
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
          if (!isset(self::$rates[$currency_code_to]) || !isset(self::$rates[$currency_code_to][$currency_code_from])) {
            self::$rates[$currency_code_to][$currency_code_from] = 1 / $rate;
          }
        }
      }
      $processed = TRUE;
    }
  }
}

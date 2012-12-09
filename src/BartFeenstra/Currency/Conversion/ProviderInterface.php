<?php

/**
 * @file
 * Contains interface ProviderInterface.
 */

namespace BartFeenstra\Currency\Conversion;

/**
 * Describes a currency conversion rate provider.
 */
interface ProviderInterface {

  /**
   * Returns the conversion rate for two currencies.
   *
   * @param string $currency_code_source
   * @param string $currency_code_destination
   *
   * @return float|false
   *   A float if the rate could be found, or FALSE otherwise.
   */
  static function rate($currency_code_source, $currency_code_destination);
}

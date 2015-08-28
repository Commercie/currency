<?php

/**
 * @file
 * Contains \Commercie\Currency\Input.
 */

namespace Commercie\Currency;

/**
 * Parses user-input amounts.
 */
class Input implements InputInterface {

  /**
   * The supported decimal separators.
   *
   * @var string[]
   */
  protected $decimalSeparators = [
    // A comma.
    ',',
    // A period (full stop).
    '.',
    // Arabic decimal separator.
    '٫',
    // A Persian Momayyez (forward slash).
    '/',
  ];

  public function parseAmount($amount) {
    if (!is_numeric($amount)) {
      $amount = static::parseAmountNegativeFormat($amount);
    }
    if (!is_numeric($amount)) {
      $amount = static::parseAmountDecimalSeparator($amount);
    }

    return is_numeric($amount) ? $amount : FALSE;
  }

  /**
   * Parses an amount's decimal separator.
   *
   * @param string $amount
   *   Any optionally localized numeric value.
   *
   * @return string|false
   *   The amount with its decimal separator replaced by a period, or FALSE in
   *   case of failure.
   */
  protected function parseAmountDecimalSeparator($amount) {
    $decimal_separator_counts = [];
    foreach ($this->decimalSeparators as $decimal_separator) {
      $decimal_separator_counts[$decimal_separator] = \mb_substr_count($amount, $decimal_separator);
    }
    $decimal_separator_counts_filtered = array_filter($decimal_separator_counts);
    if (count($decimal_separator_counts_filtered) > 1 || reset($decimal_separator_counts_filtered) !== FALSE && reset($decimal_separator_counts_filtered) != 1) {
      return FALSE;
    }
    return str_replace($this->decimalSeparators, '.', $amount);
  }

  /**
   * Parses a negative amount.
   *
   * @param string $amount
   *
   * @return string
   *   The amount with negative formatting replaced by a minus sign prefix.
   */
  protected function parseAmountNegativeFormat($amount) {
    // An amount wrapped in parentheses.
    $amount = preg_replace('/^\((.*?)\)$/', '-\\1', $amount);
    // An amount suffixed by a minus sign.
    $amount = preg_replace('/^(.*?)-$/', '-\\1', $amount);
    // Double minus signs.
    $amount = preg_replace('/--/', '', $amount);

    return $amount;
  }
}

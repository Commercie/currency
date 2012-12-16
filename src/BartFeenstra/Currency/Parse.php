<?php

/**
 * @file
 * Contains class \BartFeenstra\Currency\Parse.
 */

namespace BartFeenstra\Currency;

/**
 * Currency (amount) parsing functions.
 */
class Parse {

  protected static $decimalSeparators = array(
    // A comma.
    ',',
    // A period (full stop).
    '.',
    // Arabic decimal separator.
    '٫',
    // A Persian Momayyez (forward slash).
    '/');

  /**
   * Parses an amount.
   *
   * @throws AmountNotNumericException
   *
   * @param integer|float|string $amount
   *   Any numeric value, or a string in an optionally localized format.
   *
   * @return float
   */
  public static function amount($amount) {
    if (is_numeric($amount)) {
      return (float) $amount;
    }
    $amount = self::amountParseDecimalSeparator($amount);
    $amount = self::amountParseNegative($amount);
    if (is_numeric($amount)) {
      return (float) $amount;
    }
    else {
      throw new AmountNotNumericException('The amount could not be interpreted as a numeric string.');
    }
  }

  /**
   * Parses an amount's decimal separator.
   *
   * @throws AmountInvalidDecimalSeparatorException
   *
   * @param string $amount
   *
   * @return string
   *   The amount with its decimal separator replaced by a period.
   */
  public static function amountParseDecimalSeparator($amount) {
    $decimal_separator_counts = array();
    foreach (self::$decimalSeparators as $decimal_separator) {
      $decimal_separator_counts[$decimal_separator] = \mb_substr_count($amount, $decimal_separator);
    }
    $decimal_separator_counts_filtered = array_filter($decimal_separator_counts);
    if (count($decimal_separator_counts_filtered) > 1 || reset($decimal_separator_counts_filtered) !== FALSE && reset($decimal_separator_counts_filtered) != 1) {
      throw new AmountInvalidDecimalSeparatorException(strtr('The amount can only have no or one decimal separator and it must be one of "decimalSeparators".', array(
       'decimalSeparators' => implode(self::$decimalSeparators),
      )));
    }
    $amount = str_replace(self::$decimalSeparators, '.', $amount);

    return $amount;
  }

  /**
   * Parses a negative amount.
   *
   * @param string $amount
   *
   * @return string
   *   The amount with negative formatting replaced by a minus sign prefix.
   */
  public static function amountParseNegative($amount) {
    // An amount wrapped in parentheses.
    $amount = preg_replace('/^\((.*?)\)$/', '-\\1', $amount);
    // An amount suffixed by a minus sign.
    $amount = preg_replace('/^(.*?)-$/', '-\\1', $amount);
    // Double minus signs.
    $amount = preg_replace('/--/', '', $amount);

    return $amount;
  }
}

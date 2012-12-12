<?php

/**
 * @file
 * Contains class \BartFeenstra\Currency\Currency.
 */

namespace BartFeenstra\Currency;

/**
 * Describes a currency.
 */
class Currency extends CommonAbstract {

  /**
   * Alternative (non-official) currency signs.
   *
   * @var array
   *   An array of strings that are similar to Currency::sign.
   */
  public $alternativeSigns = array();

  /**
   * Conversion rates to other currencies.
   *
   * @var array
   *   Keys are ISO 4217 codes, values are integers or floats.
   */
  public $conversionRates = array();

  /**
   * ISO 4217 currency code.
   *
   * @var string
   */
  public $ISO4217Code = NULL;

  /**
   * The minor unit, or exponent (as in 10^$minor_unit) that results in the
   * number of minor units.
   *
   * @var integer
   */
  public $minorUnit = NULL;

  /**
   * ISO 4217 currency number.
   *
   * @var string
   */
  public $ISO4217Number = NULL;

  /**
   * The currency's official sign, such as '€' or '$'.
   *
   * @var string
   */
  public $sign = '¤';

  /**
   * Human-readable title in US English.
   *
   * @var string
   */
  public $title = NULL;

  /**
   * This currency's usage.
   *
   * @var array
   *   An array of \BartFeenstra\Currency\Usage objects.
   */
  public $usage = array();
}

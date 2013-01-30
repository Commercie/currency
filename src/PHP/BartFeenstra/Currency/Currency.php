<?php

/**
 * @file
 * Contains class \BartFeenstra\Currency\Currency.
 */

namespace BartFeenstra\Currency;

use Symfony\Component\Yaml\Yaml;

/**
 * Describes a currency.
 */
class Currency {

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

  /**
   * The path to the resources directory.
   */
  public static $resourcePath = '/../../../../resources/';

  /**
   * A list of the ISO 4217 codes of all known currency resources.
   */
  public static $resourceISO4217Codes = array();

  /**
   * The name of the currency usage class.
   *
   * @var string
   *   The class must extend BartFeenstra\Currency\Usage.
   */
  public static $resourceUsageClass = 'BartFeenstra\Currency\Usage';

  /**
   * Returns the directory that contains the currency resources.
   *
   * @return string
   */
  public static function resourceDir() {
    return __DIR__ . self::$resourcePath;
  }

  /**
   * Lists all currency resources in the library.
   *
   * @return array
   *   An array with ISO 4217 currency codes.
   */
  public static function resourceListAll() {
    if (!self::$resourceISO4217Codes) {
      $directory = new \RecursiveDirectoryIterator(self::resourceDir());
      foreach ($directory as $item) {
        if (preg_match('#^...\.yaml$#', $item->getFilename())) {
          self::$resourceISO4217Codes[] = substr($item->getFilename(), 0, 3);
        }
      }
    }

    return self::$resourceISO4217Codes;
  }

  /**
   * Loads a currency resource.
   *
   * @param string $iso_4217_code
   *
   * @return Currency|false
   */
  public static function resourceLoad($iso_4217_code) {
    $filepath = self::resourceDir() . "$iso_4217_code.yaml";
    if (file_exists($filepath)) {
      return self::resourceParse(file_get_contents($filepath));
    }
    return FALSE;
  }

  /**
   * Loads all currency resources.
   *
   * @return array
   *   An array of Currency objects.
   */
  public static function resourceLoadAll() {
    $currencies = array();
    foreach (self::resourceListAll() as $iso_4217_code) {
      $currencies[$iso_4217_code] = self::resourceLoad($iso_4217_code);
    }

    return $currencies;
  }

  /**
   * Parses a YAML file into an object of this class.
   *
   * @param string $yaml
   *
   * @return Currency|false
   */
  public static function resourceParse($yaml) {
    if ($currency_data = Yaml::parse($yaml)) {
      $usages_data = $currency_data['usage'];
      $currency_data['usage'] = array();
      $class = get_called_class();
      $currency = new $class();
      foreach ($currency_data as $property => $value) {
        $currency->$property = $value;
      }
      foreach ($usages_data as $usage_data) {
        $usage = new self::$resourceUsageClass();
        foreach ($usage_data as $property => $value) {
          $usage->$property = $value;
        }
        $currency->usage[] = $usage;
      }
      unset($currency_data);
      return $currency;
    }
    return FALSE;
  }

  /**
   * Dumps this object to YAML code.
   *
   * @return string
   */
  public function resourceDump() {
    $currency_data = get_object_vars($this);
    $currency_data['usage'] = array();
    foreach ($this->usage as $usage) {
      $currency_data['usage'][] = get_object_vars($usage);
    }

    return Yaml::dump($currency_data);
  }
}

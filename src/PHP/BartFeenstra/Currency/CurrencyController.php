<?php

/**
 * @file
 * Contains class \BartFeenstra\Currency\CurrencyController.
 */

namespace BartFeenstra\Currency;

use Symfony\Component\Yaml\Yaml;

/**
 * CRUD functions for Currency objects.
 */
class CurrencyController {

  /**
   * The path to the resources directory.
   */
  const RESOURCES = '../../../../resources/';

  /**
   * A list of the ISO 4217 codes of all known currencies in the library.
   */
  protected static $ISO4217Codes = array();

  /**
   * Lists all currencies in the library.
   *
   * @return array
   *   An array with ISO 4217 currency codes.
   */
  public static function getList() {
    if (!self::$ISO4217Codes) {
      $path = __DIR__ . '/' . self::RESOURCES;
      $directory = new \RecursiveDirectoryIterator($path);
      foreach ($directory as $item) {
        if (preg_match('#^...\.yaml$#', $item->getFilename())) {
          self::$ISO4217Codes[] = substr($item->getFilename(), 0, 3);
        }
      }
    }

    return self::$ISO4217Codes;
  }

  /**
   * Resets the list of all currencies in the library.
   */
  public static function resetList() {
    self::$ISO4217Codes = array();
  }

  /**
   * Loads a currency.
   *
   * @param string $iso_4217_code
   *
   * @return Currency|false
   */
  public static function load($iso_4217_code) {
    $filepath = __DIR__ . '/' . self::RESOURCES . "$iso_4217_code.yaml";
    if (file_exists($filepath)) {
      return self::parse(file_get_contents($filepath));
    }
    return FALSE;
  }

  /**
   * Loads all currencies.
   *
   * @return array
   */
  public static function loadAll() {
    $currencies = array();
    foreach (self::getList() as $iso_4217_code) {
      $currencies[$iso_4217_code] = self::load($iso_4217_code);
    }

    return $currencies;
  }

  /**
   * Parses a YAML file into a Currency object.
   *
   * @param string $yaml
   *
   * @return Currency|false
   */
  public static function parse($yaml) {
    if ($currency_data = Yaml::parse($yaml)) {
      $usages_data = $currency_data['usage'];
      $currency_data['usage'] = array();
      $currency = new Currency($currency_data);
      foreach ($usages_data as $usage_data) {
        $currency->usage[] = new Usage($usage_data);
      }
      unset($currency_data);
      return $currency;
    }
    return FALSE;
  }
}

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
   * The path from the root to the directory with predefined currencies.
   */
  const DIRECTORY_PREDEFINED = 'config/currencies/predefined/';

  /**
   * The path from the root to the directory with custom currencies.
   */
  const DIRECTORY_CUSTOM = 'config/currencies/custom/';

  /**
   * The path to the root directory.
   */
  const DIRECTORY_ROOT = '../../../';

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
      $paths = array(__DIR__ . '/' . self::DIRECTORY_ROOT . self::DIRECTORY_PREDEFINED, __DIR__ . '/' . self::DIRECTORY_ROOT . self::DIRECTORY_CUSTOM);
      foreach ($paths as $path) {
        $directory = new \RecursiveDirectoryIterator($path);
        foreach ($directory as $item) {
          if (preg_match('#^...\.yaml$#', $item->getFilename())) {
            self::$ISO4217Codes[] = substr($item->getFilename(), 0, 3);
          }
        }
      }
    }

    return array_unique(self::$ISO4217Codes);
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
   * @param boolean $custom
   *   Whether to look for a custom currency definition first.
   *
   * @return Currency|false
   */
  public static function load($iso_4217_code, $custom = TRUE) {
    $directories = array(self::DIRECTORY_PREDEFINED);
    if ($custom) {
      array_unshift($directories, self::DIRECTORY_CUSTOM);
    }
    foreach ($directories as $directory) {
      $filepath = __DIR__ . '/' . self::DIRECTORY_ROOT . "$directory/$iso_4217_code.yaml";
      if (file_exists($filepath)) {
        return self::parse(file_get_contents($filepath));
      }
    }
    return FALSE;
  }

  /**
   * Loads all currencies.
   * @param boolean $custom
   *   Whether to look for custom currency definitions first.
   *
   * @return array
   */
  public static function loadAll($custom = TRUE) {
    $currencies = array();
    foreach (self::getList() as $iso_4217_code) {
      $currencies[$iso_4217_code] = self::load($iso_4217_code, $custom);
    }

    return $currencies;
  }

  /**
   * Saves a custom currency.
   *
   * @param Currency $currency
   *
   * @return boolean
   */
  public static function save(Currency $currency) {
    $result = file_put_contents(__DIR__ . '/' . self::DIRECTORY_ROOT . self::DIRECTORY_CUSTOM . $currency->ISO4217Code . '.yaml', self::dump($currency));
    if ($result) {
      self::$ISO4217Codes[] = $currency->ISO4217Code;
    }

    return $result;
  }

  /**
   * Deletes a custom currency.
   *
   * @param string $iso_4217_code
   *
   * @return boolean
   */
  public static function delete($iso_4217_code) {
    $result = unlink(__DIR__ . '/' . self::DIRECTORY_ROOT . self::DIRECTORY_CUSTOM . "$iso_4217_code.yaml");
    if ($result) {
      unset(self::$ISO4217Codes[array_search($iso_4217_code, self::$ISO4217Codes)]);
    }

    return $result;
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

  /**
   * Dumps a Currency object to YAML code.
   *
   * @param string $filepath
   *
   * @return Currency|false
   */
  public static function dump(Currency $currency) {
    $currency_data = get_object_vars($currency);
    $currency_data['usage'] = array();
    foreach ($currency->usage as $usage) {
      $currency_data['usage'][] = get_object_vars($usage);
    }

    return Yaml::dump($currency_data);
  }
}

<?php

/**
 * @file
 * Contains class BartFeenstra\Currency\Conversion\Converter.
 */

namespace BartFeenstra\Currency\Conversion;

/**
 * Provides currency conversion functionality.
 */
class Converter {

  /**
   * A list of currency conversion rate providers.
   *
   * @var
   *   Values are the names of classes that implement
   *   BartFeenstra\Currency\Conversion\ProviderInterface.
   */
  private static $providers = array();

  /**
   * Gets a currency conversion rate.
   *
   * @param string $currency_code_source
   * @param string $currency_code_destination
   *
   * @return float|false
   */
  static function rate($currency_code_source, $currency_code_destination) {
    foreach (self::$providers as $provider) {
      $rate = $provider::rate($currency_code_source, $currency_code_destination);
      if (is_numeric($rate)) {
        return $rate;
      }
    }
    return FALSE;
  }

  /**
   * Gets all currently set currency conversion rate providers.
   *
   * @return array
   */
  static function getProviders() {
    return self::$providers;
  }

  /**
   * Sets a currency conversion rate provider for use.
   *
   * @param string $provider
   *   The name of a class that implements
   *   BartFeenstra\Currency\Conversion\ProviderInterface.
   *
   * @return NULL
   */
  static function registerProvider($provider) {
    self::validateProvider($provider);
    self::$providers[] = $provider;
  }

  /**
   * Unsets a currency conversion rate provider for use.
   *
   * @param string $provider
   *   The name of a class that implements
   *   BartFeenstra\Currency\Conversion\ProviderInterface.
   *
   * @return NULL
   */
  static function unregisterProvider($provider) {
    self::validateProvider($provider);
    unset(self::$providers[array_search($provider, self::$providers)]);
  }

  /**
   * Validates whether a class is a currency conversion rate provider.
   *
   * @throws InvalidArgumentException
   *
   * @param string $provider
   *   The name of a class that implements
   *   BartFeenstra\Currency\Conversion\ProviderInterface.
   */
  static function validateProvider($provider) {
    if (!is_string($provider)) {
      throw new \InvalidArgumentException("$provider is not a valid class name.");
    }
    if (!class_exists($provider)) {
      throw new \InvalidArgumentException("Class $provider does not exist.");
    }
    $interface = 'BartFeenstra\Currency\Conversion\ProviderInterface';
    if (!in_array($interface, class_implements($provider))) {
      throw new \InvalidArgumentException("Class $provider does not implement $interface.");
    }
  }
}

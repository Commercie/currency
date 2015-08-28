<?php

/**
 * @file
 * Contains \Commercie\Currency\ResourceRepository.
 */

namespace Commercie\Currency;

/**
 * Provides access to the available resources.
 */
class ResourceRepository {

  /**
   * The codes of the available currencies.
   *
   * @var string[]
   */
  protected $currencyCodes;

  /**
   * Gets the currency resource directory.
   *
   * @return string
   */
  protected function getCurrencyResourceDirectory() {
    return __DIR__ . '/../resources/currency';
  }

  /**
   * Lists all known currencies.
   *
   * @return string[]
   *   An array with ISO 4217 currency codes.
   */
  public function listCurrencies() {
    if (is_null($this->currencyCodes)) {
      $directory = new \RecursiveDirectoryIterator($this->getCurrencyResourceDirectory());
      foreach ($directory as $item) {
        if (preg_match('#^...\.json$#', $item->getFilename())) {
          $this->currencyCodes[] = substr($item->getFilename(), 0, 3);
        }
      }
    }

    return $this->currencyCodes;
  }

  /**
   * Loads a currency.
   *
   * @param string $currencyCode
   *
   * @return \Commercie\Currency\CurrencyInterface|null
   */
  public function loadCurrency($currencyCode) {
    $filePath = $this->getCurrencyResourceDirectory() . "/$currencyCode.json";
    if (is_readable($filePath)) {
      return $this->createCurrencyFromJson(file_get_contents($filePath));
    }
    else {
      return null;
    }
  }

  /**
   * Creates a currency from its JSON resource.
   *
   * @param string $json
   *
   * @return \Commercie\Currency\CurrencyInterface
   */
  protected function createCurrencyFromJson($json) {
    $currency_data = json_decode($json);

    $currency = new Currency();
    $currency->setCurrencyCode($currency_data->ISO4217Code);
    if (isset($currency_data->ISO4217Number)) {
      $currency->setCurrencyNumber($currency_data->ISO4217Number);
    }
    if (isset($currency_data->alternativeSigns)) {
      $currency->setAlternativeSigns($currency_data->alternativeSigns);
    }
    $currency->setLabel($currency_data->title);
    if (isset($currency_data->roundingStep)) {
      $currency->setRoundingStep($currency_data->roundingStep);
    }
    if (isset($currency_data->sign)) {
      $currency->setSign($currency_data->sign);
    }
    if (isset($currency_data->subunits)) {
      $currency->setSubunits($currency_data->subunits);
    }

    $usages_data = $currency_data->usage;
    $usages = [];
    foreach ($currency_data as $property => $value) {
      $this->$property = $value;
    }
    foreach ($usages_data as $usage_data) {
      $usage = new Usage();
      if (isset($usage_data->ISO8601From)) {
        $usage->setStart($usage_data->ISO8601From);
      }
      if (isset($usage_data->ISO8601To)) {
        $usage->setEnd($usage_data->ISO8601To);
      }
      if (isset($usage_data->ISO3166Code)) {
        $usage->setCountryCode($usage_data->ISO3166Code);
      }
      $usages[] = $usage;
    }
    $currency->setUsages($usages);

    return $currency;
  }

}

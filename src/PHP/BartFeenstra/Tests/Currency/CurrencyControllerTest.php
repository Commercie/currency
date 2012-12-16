<?php

/**
 * @file
 * Contains class \BartFeenstra\Tests\Currency\CurrencyControllerTest.
 */

namespace BartFeenstra\Tests\Currency;

use BartFeenstra\Currency\Currency;
use BartFeenstra\Currency\CurrencyController;
use BartFeenstra\Currency\Usage;

require_once __DIR__ . '/../../../../../vendor/autoload.php';

/**
 * Tests \BartFeenstra\Currency\CurrencyController
 */
class CurrencyControllerTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test listing .
   */
  function testGetList() {
    $list = CurrencyController::getList();
    foreach ($list as $iso_4217_code) {
      $this->assertSame(strlen($iso_4217_code), 3, 'CurrencyController::getList() returns an array with three-letter strings (ISO 4217 codes).');
    }
  }

  /**
   * Returns YAML for a Currency object.
   *
   * @return string
   */
  function yaml() {
    return <<<'EOD'
alternativeSigns: {  }
conversionRates: {  }
ISO4217Code: EUR
minorUnit: 2
ISO4217Number: '978'
sign: ¤
title: Euro
usage:
    - { ISO8601From: '2003-02-04', ISO8601To: '2006-06-03', ISO3166Code: CS }
EOD;
  }

  /**
   * Returns a Currency object.
   *
   * @return Currency
   */
  function currency() {
    return new Currency(array(
      'ISO4217Code' => 'EUR',
      'minorUnit' => 2,
      'ISO4217Number' => '978',
      'sign' => '¤',
      'title' => 'Euro',
      'usage' => array(new Usage(array(
        'ISO8601From' => '2003-02-04',
        'ISO8601To' => '2006-06-03',
        'ISO3166Code' => 'CS',
      ))),
    ));
  }

  /**
   * Test YAML parsing .
   */
  function testParse() {
    $yaml = $this->yaml();
    $currency_parsed = CurrencyController::parse($yaml);
    $this->assertInstanceOf('BartFeenstra\Currency\Currency', $currency_parsed, 'CurrencyController::parse() parses YAML code to a Currency object.');
    $this->assertInstanceOf('BartFeenstra\Currency\Usage', $currency_parsed->usage[0], 'CurrencyController::parse() parses YAML code to a Usage object.');
    $currency = $this->currency();
    $this->assertSame(get_object_vars($currency->usage[0]), get_object_vars($currency_parsed->usage[0]), 'CurrencyController::parse() parses YAML code to an identical Usage object.');
    unset($currency->usage);
    unset($currency_parsed->usage);
    $this->assertSame(get_object_vars($currency), get_object_vars($currency_parsed), 'CurrencyController::parse() parses YAML code to an identical currency object.');
  }

  /**
   * Tests loading a single currency.
   */
  function testLoad() {
    $currency = CurrencyController::load('EUR');
    $this->assertInstanceOf('BartFeenstra\Currency\Currency', $currency, 'CurrencyController::load() loads a single currency from file.');
  }

  /**
   * Tests loading all currencies.
   *
   * @depends testLoad
   */
  function testLoadAll() {
    CurrencyController::loadAll();
  }
}

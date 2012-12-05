<?php

/**
 * @file
 * Contains class \BartFeenstra\Tests\Currency\CurrencyControllerTest.
 */

namespace BartFeenstra\Tests\CLDR;

use BartFeenstra\Currency\Currency;
use BartFeenstra\Currency\CurrencyController;
use BartFeenstra\Currency\Usage;

require_once __DIR__ . '/../../../../vendor/autoload.php';

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
   * Test Currency dumping .
   */
  function testDump() {
    $currency = $this->currency();
    $yaml_dumped = CurrencyController::dump($currency);
    $this->assertInternalType('string', $yaml_dumped, 'CurrencyController::dump() returns a string.');
    $yaml = $this->yaml();
    $this->assertSame(trim($yaml), trim($yaml_dumped), 'CurrencyController::dump() correctly dumps a Currency object to YAML.');
  }

  /**
   * Tests saving a custom currency.
   *
   * @depends testDump
   */
  function testSave() {
    $currency = $this->currency();
    $currency->ISO4217Code = 'ZZZ';
    CurrencyController::save($currency);
    $this->assertFileExists(__DIR__ . '/../' . CurrencyController::DIRECTORY_ROOT . CurrencyController::DIRECTORY_CUSTOM . $currency->ISO4217Code . '.yaml');
    $this->assertContains($currency->ISO4217Code, CurrencyController::getList());
  }

  /**
   * Tests loading a custom currency.
   *
   * @depends testSave
   */
  function testLoad() {
    $currency = CurrencyController::load('ZZZ', TRUE);
    $this->assertInstanceOf('BartFeenstra\Currency\Currency', $currency, 'CurrencyController::load() loads a custom currency from file.');
  }

  /**
   * Tests deleting a custom currency.
   *
   * @depends testSave
   */
  function testDelete() {
    $iso_4217_code = 'ZZZ';
    CurrencyController::delete($iso_4217_code);
    $this->assertFileNotExists(__DIR__ . '/../' . CurrencyController::DIRECTORY_ROOT . CurrencyController::DIRECTORY_CUSTOM . $iso_4217_code . '.yaml');
    $this->assertNotContains($iso_4217_code, CurrencyController::getList());
  }
}

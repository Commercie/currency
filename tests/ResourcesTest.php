<?php

/**
 * @file
 * Contains class \BartFeenstra\Tests\Currency\Resources.
 */

namespace BartFeenstra\Tests\Currency;

use BartFeenstra\Currency\Currency;

/**
 * Tests resource files.
 */
class Resources extends \PHPUnit_Framework_TestCase {

  /**
   * Tests resource integrity.
   */
  function testResourceIntegrity() {
    foreach (Currency::resourceListAll() as $ISO4217Code) {
      $currency = new Currency();
      $currency->resourceLoad($ISO4217Code);
    }
  }
}

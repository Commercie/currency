<?php

/**
 * @file
 * Contains class \BartFeenstra\Tests\Currency\Conversion\ConverterTest.
 */

namespace BartFeenstra\Tests\Currency\Conversion;

use BartFeenstra\Currency\Conversion\Converter;

require_once __DIR__ . '/../../../../../vendor/autoload.php';

/**
 * Tests \BartFeenstra\Currency\Conversion\Converter.
 */
class ConverterTest extends \PHPUnit_Framework_TestCase {

  private $provider = 'BartFeenstra\Currency\Conversion\HistoricalProvider';

  /**
   * Tests validateProvider().
   */
  function testValidateProvider() {
    try {
      Converter::validateProvider($this->provider);
      $valid = TRUE;
    }
    catch (\InvalidArgumentException $e) {
      $valid = FALSE;
    }
    $this->assertTrue($valid);
    $providers_invalid = array(
      // Not a valid class name.
      5,
      // No existing class.
      'FooBarBazQux',
      // A valid class, but not a valid provider.
      'BartFeenstra\Tests\Currency\Conversion\ConverterTest',
    );
    foreach ($providers_invalid as $provider_invalid) {
      try {
        Converter::validateProvider($provider_invalid);
        $valid = TRUE;
      }
      catch (\InvalidArgumentException $e) {
        $valid = FALSE;
      }
      $this->assertFalse($valid);
    }
  }

  /**
   * Tests registerProvider() and getProviders().
   *
   * @depends testValidateProvider
   */
  function testSetGetProvider() {
    Converter::registerProvider($this->provider);
    $this->assertContains($this->provider, Converter::getProviders());
  }

  /**
   * Tests unregisterProvider().
   *
   * @depends testSetGetProvider
   */
  function testUnregisterProvider() {
    $this->assertContains($this->provider, Converter::getProviders());
    Converter::unregisterProvider($this->provider);
    $this->assertNotContains($this->provider, Converter::getProviders());
  }

  /**
   * Tests rate().
   *
   * @depends testSetGetProvider
   */
  function testRate() {
    Converter::registerProvider($this->provider);
    $this->assertSame(Converter::rate('EUR', 'NLG'), 2.20371, '<code>currency_conversion_rate()</code> returns conversion rates as a float.');
    $this->assertSame(Converter::rate('123', '456'), FALSE, '<code>currency_conversion_rate()</code> returns <code>FALSE</code> if it cannot find a conversion rate.');
  }
}

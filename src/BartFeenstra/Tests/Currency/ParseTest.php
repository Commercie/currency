<?php

/**
 * @file
 * Contains class \BartFeenstra\Tests\Currency\ParseTest.
 */

namespace BartFeenstra\Tests\CLDR;

use BartFeenstra\Currency\Parse;

require_once __DIR__ . '/../../../../vendor/autoload.php';

/**
 * Tests \BartFeenstra\Currency\Validate
 */
class ValidateTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests amount().
   */
  function testAmount() {
    $amounts_invalid = array(
      'BartFeenstra\Currency\AmountNotNumericException' => array(
        'a',
        'a123',
        '123%',
      ),
      'BartFeenstra\Currency\AmountInvalidDecimalSeparatorException' => array(
        '.5.',
        '123,456,789.00,00',
      ),
    );
    foreach ($amounts_invalid as $exception_class => $amounts) {
      foreach ($amounts as $amount) {
        $valid = TRUE;
        try {
          Parse::amount($amount);
        }
        catch (\Exception $e) {
          if ($e instanceof $exception_class) {
            $valid = FALSE;
          }
        }
        $this->assertFalse($valid);
      }
    }
    $amounts_valid = array(
      // Integers.
      array(123, 123.0),
      // Floats.
      array(123.456, 123.456),
      array(-123.456, -123.456),
      // Integer strings.
      array('123', 123.0),
      // Float strings using different decimal separators.
      array('123.456', 123.456),
      array('123,456', 123.456),
      array('123٫456', 123.456),
      array('123/456', 123.456),
      // Negative strings.
      array('-123', -123.0),
      array('(123)', -123.0),
      array('123-', -123.0),
      array('--123', 123.0),
      array('(--123-)', 123.0),
    );
    foreach ($amounts_valid as $amount) {
      $amount_validated = NULL;
      $amount_validated = Parse::amount($amount[0]);
      $this->assertSame($amount_validated, $amount[1]);
    }
  }
}

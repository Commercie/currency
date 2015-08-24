<?php

/**
 * @file
 * Contains class \BartFeenstra\Tests\Currency\ParseTest.
 */

namespace BartFeenstra\Tests\Currency;

use BartFeenstra\Currency\Input;

/**
 * @coversDefaultClass \BartFeenstra\Currency\Input
 */
class InputTest extends \PHPUnit_Framework_TestCase {

  /**
   * @covers ::parseAmount
   * @covers ::parseAmountDecimalSeparator
   * @covers ::parseAmountNegativeFormat
   */
  function testParseAmount() {
    $amounts_invalid = [
      'BartFeenstra\Currency\AmountNotNumericException' => [
        'a',
        'a123',
        '123%',
      ],
      'BartFeenstra\Currency\AmountInvalidDecimalSeparatorException' => [
        '.5.',
        '123,456,789.00,00',
      ],
    ];
    foreach ($amounts_invalid as $exception_class => $amounts) {
      foreach ($amounts as $amount) {
        $valid = TRUE;
        try {
          Input::parseAmount($amount);
        }
        catch (\Exception $e) {
          if ($e instanceof $exception_class) {
            $valid = FALSE;
          }
        }
        $this->assertFalse($valid);
      }
    }
    $amounts_valid = [
      // Integers.
      [123, '123'],
      // Floats.
      [123.456, '123.456'],
      [-123.456, '-123.456'],
      // Integer strings.
      ['123', '123'],
      // Decimal strings using different decimal separators.
      ['123.456', '123.456'],
      ['123,456', '123.456'],
      ['123٫456', '123.456'],
      ['123/456', '123.456'],
      // Negative strings.
      ['-123', '-123'],
      ['(123)', '-123'],
      ['123-', '-123'],
      ['--123', '123'],
      ['(--123-)', '123'],
    ];
    foreach ($amounts_valid as $amount) {
      $amount_validated = NULL;
      $amount_validated = Input::parseAmount($amount[0]);
      $this->assertSame($amount_validated, $amount[1]);
    }
  }
}

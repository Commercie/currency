<?php

/**
 * @file
 * Contains \Commercie\Tests\Currency\InputTest.
 */

namespace Commercie\Tests\Currency;

use Commercie\Currency\Input;

/**
 * @coversDefaultClass \Commercie\Currency\Input
 *
 * @group Currency
 */
class InputTest extends \PHPUnit_Framework_TestCase {

  /**
   * The class under test.
   *
   * @var \Commercie\Currency\Input
   */
  protected $sut;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->sut = new Input();
  }

  /**
   * @covers ::parseAmount
   * @covers ::parseAmountDecimalSeparator
   * @covers ::parseAmountNegativeFormat
   */
  public function testParseAmount() {
    $amounts_invalid = [
      'a',
      'a123',
      '123%',
      '.5.',
      '123,456,789.00,00',
    ];
    foreach ($amounts_invalid as $amount) {
      $this->assertFalse($this->sut->parseAmount($amount));
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
      $amount_validated = $this->sut->parseAmount($amount[0]);
      $this->assertEquals($amount_validated, $amount[1]);
    }
  }

}

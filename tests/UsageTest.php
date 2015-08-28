<?php

/**
 * @file Contains \Commercie\Tests\Currency\UsageTest.
 */

namespace Commercie\Tests\Currency;
use Commercie\Currency\Usage;

/**
 * @coversDefaultClass \Commercie\Currency\Usage
 *
 * @group Currency
 */
class UsageTest extends \PHPUnit_Framework_TestCase {

  /**
   * The class under test.
   *
   * @var \Commercie\Currency\Usage
   */
  protected $sut;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->sut = new Usage();
  }

  /**
   * @covers ::setStart
   * @covers ::getStart
   */
  public function testGetStart() {
    $start = 'foo' . mt_rand();

    $this->assertSame($this->sut, $this->sut->setStart($start));
    $this->assertSame($start, $this->sut->getStart());
  }

  /**
   * @covers ::setEnd
   * @covers ::getEnd
   */
  public function testGetEnd() {
    $end = 'foo' . mt_rand();

    $this->assertSame($this->sut, $this->sut->setEnd($end));
    $this->assertSame($end, $this->sut->getEnd());
  }

  /**
   * @covers ::setCountryCode
   * @covers ::getCountryCode
   */
  public function testGetCountryCode() {
    $country_code = 'foo' . mt_rand();

    $this->assertSame($this->sut, $this->sut->setCountryCode($country_code));
    $this->assertSame($country_code, $this->sut->getCountryCode());
  }

}

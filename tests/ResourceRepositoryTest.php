<?php

/**
 * @file
 * Contains \BartFeenstra\Tests\Currency\ResourceRepositoryTest.
 */

namespace BartFeenstra\Tests\Currency;

use BartFeenstra\Currency\CurrencyInterface;
use BartFeenstra\Currency\ResourceRepository;
use BartFeenstra\Currency\UsageInterface;

/**
 * @coversDefaultClass \BartFeenstra\Currency\ResourceRepository
 *
 * @group Currency
 */
class ResourceRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The subject under test.
     *
     * @var \BartFeenstra\Currency\ResourceRepository
     */
    protected $sut;

    public function setUp()
    {
        $this->sut = new ResourceRepository();
    }

    /**
     * @covers ::listCurrencies
     * @covers ::getCurrencyResourceDirectory
     */
    public function testListCurrencies()
    {
        $currencyCodes = $this->sut->listCurrencies();
        $this->assertInternalType('array', $currencyCodes);
        // This is a very crude check to see if enough currencies are found.
        $this->assertTrue(count($currencyCodes) > 99);
        foreach ($currencyCodes as $currencyCode) {
            $this->assertInternalType('string', $currencyCode);
        }
    }

    /**
     * @covers ::loadCurrency
     * @covers ::getCurrencyResourceDirectory
     * @covers ::createCurrencyFromJson
     *
     * @depends testListCurrencies
     */
    public function testLoadCurrency()
    {
        foreach ($this->sut->listCurrencies() as $currencyCode) {
            $currency = $this->sut->loadCurrency($currencyCode);
            $this->assertInstanceOf(CurrencyInterface::class, $currency);
            foreach ($currency->getUsages() as $usage) {
                $this->assertInstanceOf(UsageInterface::class, $usage);
            }
        }
    }

    /**
     * @covers ::loadCurrency
     *
     * @dataProvider providerLoadCurrencyWithNonExistentCurrencies
     */
    public function testLoadCurrencyWithNonExistentCurrencies($currencyCode)
    {
        $this->assertNull($this->sut->loadCurrency($currencyCode));
    }

    /**
     * Provides data to self::
     */
    public function providerLoadCurrencyWithNonExistentCurrencies() {
        return [
          ['FOO'],
          ['foo'],
          [mt_rand()],
          [NULL],
          [TRUE],
          [FALSE],
        ];
    }

}

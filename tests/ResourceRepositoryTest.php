<?php

/**
 * @file
 * Contains \Commercie\Tests\Currency\ResourceRepositoryTest.
 */

namespace Commercie\Tests\Currency;

use Commercie\Currency\CurrencyInterface;
use Commercie\Currency\ResourceRepository;
use Commercie\Currency\UsageInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Commercie\Currency\ResourceRepository
 *
 * @group Currency
 */
class ResourceRepositoryTest extends TestCase
{

    /**
     * The subject under test.
     *
     * @var \Commercie\Currency\ResourceRepository
     */
    protected $sut;

    protected function setUp(): void
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
        $this->assertIsArray($currencyCodes);
        // This is a very crude check to see if enough currencies are found.
        $this->assertTrue(count($currencyCodes) > 99);
        foreach ($currencyCodes as $currencyCode) {
            $this->assertIsString($currencyCode);
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

<?php

/**
 * @file
 * Contains \Commercie\Tests\Currency\CurrencyTest.
 */

namespace Commercie\Tests\Currency;

use Commercie\Currency\Currency;
use Commercie\Currency\Usage;

/**
 * @coversDefaultClass \Commercie\Currency\Currency
 *
 * @group Currency
 */
class CurrencyTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The subject under test.
     *
     * @var \Commercie\Currency\Currency
     */
    protected $sut;

    public function setUp()
    {
        $this->sut = new Currency();
    }

    /**
     * @covers ::getLabel
     * @covers ::setLabel
     */
    public function testGetLabel()
    {
        $label = mt_rand();

        $this->assertSame($this->sut,
          $this->sut->setLabel($label));
        $this->assertSame($label, $this->sut->getLabel());
    }

    /**
     * @covers ::getRoundingStep
     * @covers ::setRoundingStep
     */
    public function testGetRoundingStep()
    {
        $roundingStep = mt_rand();

        $this->assertSame($this->sut,
          $this->sut->setRoundingStep($roundingStep));
        $this->assertSame($roundingStep, $this->sut->getRoundingStep());
    }

    /**
     * @covers ::getRoundingStep
     */
    public function testGetRoundingStepBySubunits()
    {
        $subunits = 5;
        $roundingStep = '0.200000';

        $this->sut->setSubunits($subunits);

        $this->assertSame($roundingStep, $this->sut->getRoundingStep());
    }

    /**
     * @covers ::getRoundingStep
     */
    public function testGetRoundingStepUnavailable()
    {
        $this->assertNull($this->sut->getRoundingStep());
    }

    /**
     * @covers ::getDecimals
     */
    public function testGetDecimals()
    {
        foreach ([1, 2, 3] as $decimals) {
            $this->sut->setSubunits(pow(10, $decimals));
            $this->assertSame($decimals, $this->sut->getDecimals());
        }
    }

    /**
     * @covers ::isObsolete
     */
    public function testIsObsolete()
    {
        // A currency without usage data.
        $this->assertFalse($this->sut->isObsolete());

        // A currency that is no longer being used.
        $usage = new Usage();
        $usage->setStart('1813-01-01')
          ->setEnd('2002-02-28');
        $this->sut->setUsages([$usage]);
        $this->assertTrue($this->sut->isObsolete());

        // A currency that will become obsolete next year.
        $usage = new Usage();
        $usage->setStart('1813-01-01')
          ->setEnd(date('o') + 1 . '-02-28');
        $this->sut->setUsages([$usage]);
        $this->assertFalse($this->sut->isObsolete());
    }

    /**
     * @covers ::getAlternativeSigns
     * @covers ::setAlternativeSigns
     */
    public function testGetAlternativeSigns()
    {
        $alternative_signs = ['A', 'B'];
        $this->assertSame($this->sut,
          $this->sut->setAlternativeSigns($alternative_signs));
        $this->assertSame($alternative_signs,
          $this->sut->getAlternativeSigns());
    }

    /**
     * @covers ::getCurrencyCode
     * @covers ::setCurrencyCode
     */
    public function testGetCurrencyCode()
    {
        $currency_code = 'FOO';
        $this->assertSame($this->sut,
          $this->sut->setCurrencyCode($currency_code));
        $this->assertSame($currency_code, $this->sut->getCurrencyCode());
    }

    /**
     * @covers ::getCurrencyNumber
     * @covers ::setCurrencyNumber
     */
    public function testGetCurrencyNumber()
    {
        $currency_number = mt_rand();
        $this->assertSame($this->sut,
          $this->sut->setCurrencyNumber($currency_number));
        $this->assertSame($currency_number, $this->sut->getCurrencyNumber());
    }

    /**
     * @covers ::getSign
     * @covers ::setSign
     */
    public function testGetSign()
    {
        $sign = mt_rand();
        $this->assertSame($this->sut, $this->sut->setSign($sign));
        $this->assertSame($sign, $this->sut->getSign());
    }

    /**
     * @covers ::setSubunits
     * @covers ::getSubunits
     */
    public function testGetSubunits()
    {
        $subunits = mt_rand();
        $this->assertSame($this->sut, $this->sut->setSubunits($subunits));
        $this->assertSame($subunits, $this->sut->getSubunits());
    }

    /**
     * @covers ::setUsages
     * @covers ::getUsages
     */
    public function testGetUsage()
    {
        $usage = new Usage();
        $usage->setStart('1813-01-01')
          ->setEnd(date('o') + 1 . '-02-28');
        $this->assertSame($this->sut, $this->sut->setUsages([$usage]));
        $this->assertSame([$usage], $this->sut->getUsages());
    }

}

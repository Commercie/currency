<?php

/**
 * @file
 * Contains of \Commercie\Currency\Currency.
 */

namespace Commercie\Currency;

/**
 * Provides a currency.
 */
class Currency implements CurrencyInterface
{

    /**
     * Alternative (non-official) currency signs.
     *
     * @var array
     *   An array of strings that are similar to self::sign.
     */
    protected $alternativeSigns = [];

    /**
     * ISO 4217 currency code.
     *
     * @var string
     */
    public $currencyCode;

    /**
     * ISO 4217 currency number.
     *
     * @var string
     */
    protected $currencyNumber;

    /**
     * The human-readable name.
     *
     * @var string
     */
    public $label;

    /**
     * The number of subunits to round amounts in this currency to.
     *
     * @see Currency::getRoundingStep()
     *
     * @var integer
     */
    protected $roundingStep;

    /**
     * The currency's official sign, such as '€' or '$'.
     *
     * @var string
     */
    protected $sign = '¤';

    /**
     * The number of subunits this currency has.
     *
     * @var integer|null
     */
    protected $subunits;

    /**
     * This currency's usages.
     *
     * @var \Commercie\Currency\UsageInterface[]
     */
    protected $usages = [];

    public function setAlternativeSigns(array $signs)
    {
        $this->alternativeSigns = $signs;

        return $this;
    }

    public function getAlternativeSigns()
    {
        return $this->alternativeSigns;
    }

    public function setCurrencyCode($code)
    {
        $this->currencyCode = $code;

        return $this;
    }

    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    public function setCurrencyNumber($number)
    {
        $this->currencyNumber = $number;

        return $this;
    }

    public function getCurrencyNumber()
    {
        return $this->currencyNumber;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setRoundingStep($step)
    {
        $this->roundingStep = $step;

        return $this;
    }

    public function setSign($sign)
    {
        $this->sign = $sign;

        return $this;
    }

    public function getSign()
    {
        return $this->sign;
    }

    public function setSubunits($subunits)
    {
        $this->subunits = $subunits;

        return $this;
    }

    public function getSubunits()
    {
        return $this->subunits;
    }

    public function setUsages(array $usages)
    {
        $this->usages = $usages;

        return $this;
    }

    public function getUsages()
    {
        return $this->usages;
    }

    public function getDecimals()
    {
        $decimals = 0;
        if ($this->getSubunits() > 0) {
            $decimals = 1;
            while (pow(10, $decimals) < $this->getSubunits()) {
                $decimals++;
            }
        }

        return $decimals;
    }

    function getRoundingStep()
    {
        if (is_numeric($this->roundingStep)) {
            return $this->roundingStep;
        }
        // If a rounding step was not set explicitly, the rounding step is equal
        // to one subunit.
        elseif (is_numeric($this->getSubunits())) {
            return $this->getSubunits() > 0 ? bcdiv(1, $this->getSubunits(),
              6) : 1;
        }
        return null;
    }

    function isObsolete($reference = null)
    {
        // Without usage information, we cannot know if the currency is obsolete.
        if (!$this->getUsages()) {
            return false;
        }

        // Default to the current date and time.
        if (is_null($reference)) {
            $reference = time();
        }

        // Mark the currency obsolete if all usages have an end date that comes
        // before $reference.
        $obsolete = 0;
        foreach ($this->getUsages() as $usage) {
            if ($usage->getEnd()) {
                $to = strtotime($usage->getEnd());
                if ($to !== false && $to < $reference) {
                    $obsolete++;
                }
            }
        }
        return $obsolete == count($this->getUsages());
    }

}

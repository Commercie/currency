<?php

/**
 * @file
 * Definition of Commercie\Currency\CurrencyInterface.
 */

namespace Commercie\Currency;

/**
 * Defines a currency.
 */
interface CurrencyInterface {

  /**
   * Sets alternative (non-official) currency signs.
   *
   * @param string[] $signs
   *   Values are currency signs.
   *
   * @return $this
   */
  public function setAlternativeSigns(array $signs);

  /**
   * Gets alternative (non-official) currency signs.
   *
   * @return array
   *   Values are currency signs.
   */
  public function getAlternativeSigns();

  /**
   * Sets the ISO 4217 currency code.
   *
   * The currency code is identical to the entity's ID.
   *
   * @param string $code
   *
   * @return $this
   */
  public function setCurrencyCode($code);

  /**
   * Gets the ISO 4217 currency code.
   *
   * The currency code is identical to the entity's ID.
   *
   * @see self::id()
   *
   * @return string
   */
  public function getCurrencyCode();

  /**
   * Sets the ISO 4217 currency number.
   *
   * @param string $number
   *
   * @return $this
   */
  public function setCurrencyNumber($number);

  /**
   * Gets the ISO 4217 currency number.
   *
   * @return string
   */
  public function getCurrencyNumber();

  /**
   * Sets the label.
   *
   * @param string $label
   *
   * @return $this
   */
  public function setLabel($label);

  /**
   * Gets the label.
   *
   * @return string
   */
  public function getLabel();

  /**
   * Sets the number of subunits to round amounts in this currency to.
   *
   * @param int $step
   *
   * @return $this
   */
  public function setRoundingStep($step);

  /**
   * Gets the number of subunits to round amounts in this currency to.
   *
   * @return int|null
   */
  public function getRoundingStep();

  /**
   * Sets the currency sign.
   *
   * @param string $sign
   *
   * @return $this
   */
  public function setSign($sign);

  /**
   * Gets the currency sign.
   *
   * @return string
   */
  public function getSign();

  /**
   * Sets the number of subunits.
   *
   * @param int $subunits
   *
   * @return $this
   */
  public function setSubunits($subunits);

  /**
   * Gets the number of subunits.
   *
   * @return int
   */
  public function getSubunits();

  /**
   * Sets the currency usages.
   *
   * @param \Commercie\Currency\UsageInterface[]
   *
   * @return $this
   */
  public function setUsages(array $usages);

  /**
   * Gets the currency usages.
   *
   * @return \Commercie\Currency\UsageInterface[]
   */
  public function getUsages();

  /**
   * Returns the number of decimals.
   *
   * @return int
   */
  public function getDecimals();

  /**
   * Checks if the currency is no longer used in the world.
   *
   * @param int $reference
   *   A Unix timestamp to check the currency's usage for. Defaults to now.
   *
   * @return bool|null
   */
  function isObsolete($reference = NULL);
}

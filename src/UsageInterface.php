<?php

/**
 * @file
 * Contains \Commercie\Currency\UsageInterface.
 */

namespace Commercie\Currency;

/**
 * Describes a currency's usage in a country.
 */
interface UsageInterface  {

  /**
   * Gets the date and time this usage started.
   *
   * @return string
   *   An ISO 8601 datetime.
   */
  public function getStart();

  /**
   * Sets the date and time this usage started.
   *
   * @param string $datetime
   *   An ISO 8601 datetime.
   *
   * @return $this
   */
  public function setStart($datetime);

  /**
   * Gets the date and time this usage ended.
   *
   * @return string
   *   An ISO 8601 datetime.
   */
  public function getEnd();

  /**
   * Sets the date and time this usage ended.
   *
   * @param string $datetime
   *   An ISO 8601 datetime.
   *
   * @return $this
   */
  public function setEnd($datetime);

  /**
   * Gets the country of this usage.
   *
   * @return
   *   An ISO 3166-1 alpha-1 country code.
   */
  public function getCountryCode();

  /**
   * Sets the country of this usage.
   *
   * @param string $country_code
   *   An ISO 3166-1 alpha-1 country code.
   *
   * @return $this
   */
  public function setCountryCode($country_code);

}

<?php

/**
 * @file
 * Contains \Commercie\Currency\Usage.
 */

namespace Commercie\Currency;

/**
 * Describes a currency's usage in a country.
 */
class Usage implements UsageInterface {

  /**
   * The ISO 8601 datetime of the moment this usage started.
   *
   * @var string
   */
  protected $start;

  /**
   * The ISO 8601 datetime of the moment this usage ended.
   *
   * @var string
   */
  protected $end;

  /**
   * The ISO 3166-1 alpha-1 country code.
   *
   * @var string
   */
  protected $countryCode;

  public function getStart() {
    return $this->start;
  }

  public function setStart($datetime) {
    $this->start = $datetime;

    return $this;
  }

  public function getEnd() {
    return $this->end;
  }

  public function setEnd($datetime) {
    $this->end = $datetime;

    return $this;
  }

  public function getCountryCode() {
    return $this->countryCode;
  }

  public function setCountryCode($country_code) {
    $this->countryCode = $country_code;

    return $this;
  }
}

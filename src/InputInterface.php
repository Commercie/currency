<?php

/**
 * @file
 * Contains \Commercie\Currency\InputInterface.
 */

namespace Commercie\Currency;

/**
 * Defines a solution to parse user-input amounts.
 */
interface InputInterface {

  /**
   * Parses an amount.
   *
   * @param string $amount
   *   Any optionally localized numeric string.
   *
   * @return string|false
   *   A numeric string, or FALSE in case of failure.
   */
  public function parseAmount($amount);

}

<?php

/**
 * @file
 * Contains class \BartFeenstra\Currency\CommonAbstract
 */

namespace BartFeenstra\Currency;

/**
 * Base class with common functionality.
 */
abstract class CommonAbstract {

  /**
   * Implements __construct().
   *
   * @param array $properties
   *   Keys are property names and values are property values.
   */
  function __construct(array $properties = array()) {
    foreach ($properties as $property => $value) {
      $this->$property = $value;
    }
  }
}
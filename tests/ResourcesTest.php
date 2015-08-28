<?php

/**
 * @file
 * Contains class \Commercie\Tests\Currency\Resources.
 */

namespace Commercie\Tests\Currency;

use JsonSchema\Uri\UriRetriever;
use JsonSchema\Validator;

/**
 * Tests resource files.
 */
class Resources extends \PHPUnit_Framework_TestCase {

  /**
   * Tests currency integrity.
   */
  function testCurrencyIntegrity() {
    $resourceDirectory = __DIR__ . '/../resources';

    $currencyFileNames = glob($resourceDirectory . '/currency/*.json');

    $schemaUri = 'file://' . __DIR__ . '/../resources/schema/currency.json';
    $schemaRetriever = new UriRetriever();
    $schema = $schemaRetriever->retrieve($schemaUri);

    foreach ($currencyFileNames as $currencyFileName) {
      $schemaValidator = new Validator();
      $schemaValidator->check(json_decode(file_get_contents($currencyFileName)), $schema);
      if (!$schemaValidator->isValid()) {
        foreach ($schemaValidator->getErrors() as $error) {
          $message = sprintf('%s for property %s in %s', $error['message'], $error['property'], $currencyFileName);
          $this->fail($message);
        }
      }
    }
  }
}

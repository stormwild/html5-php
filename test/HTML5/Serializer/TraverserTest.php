<?php
namespace HTML5\Tests;

use \HTML5\Serializer\Traverser;
use \HTML5\Parser;

require_once __DIR__ . '/../TestCase.php';

class TraverserTest extends \HTML5\Tests\TestCase {

  protected $markup = '<!doctype html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <title>Test</title>
      </head>
      <body>
        <p>This is a test.</p>
      </body>
    </html>';

  /**
   * Using reflection we make a protected method accessible for testing.
   * 
   * @param string $name
   *   The name of the method on the Traverser class to test.
   *
   * @return \ReflectionMethod
   *   \ReflectionMethod for the specified method
   */
  function getProtectedMethod($name) {
    $class = new \ReflectionClass('\HTML5\Serializer\Traverser');
    $method = $class->getMethod($name);
    $method->setAccessible(true);
    return $method;
  }

  function getTraverser() {
    $stream = fopen('php://temp', 'w');
    $dom = \HTML5::loadHTML($this->markup);
    $t = new Traverser($dom, $stream, \HTML5::options());

    // We return both the traverser and stream so we can pull from it.
    return array($t, $stream);
  }

  function testConstruct() {

    // The traverser needs a place to write the output to. In our case we
    // use a stream in temp space.
    $stream = fopen('php://temp', 'w');

    $dom = \HTML5::loadHTML($this->markup);

    $t = new Traverser($dom, $stream, \HTML5::options());

    $this->assertInstanceOf('\HTML5\Serializer\Traverser', $t);
  }
}
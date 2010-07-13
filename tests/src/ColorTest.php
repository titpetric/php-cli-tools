<?php
/**
 * PHP Console Tools is a console library for PHP
 *
 * PHP versions 5.3
 *
 * @category  ToolsAndUtilities
 * @package   phpDocumentor2
 * @author    James Logsdon <jlogsdon@php.net>
 * @copyright 2010 phpDocumentor2 Team
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @link      http://www.github.com/mfacenet/phpDocumentor
 */

use Console\Color;

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Test case for Console\Color
 *
 * @category  ToolsAndUtilities
 * @package   phpDocumentor2
 * @author    James Logsdon <jlogsdon@php.net>
 * @copyright 2010 phpDocumentor2 Team
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @link      http://www.github.com/mfacenet/phpDocumentor
 */
class ColorTest extends PHPUnit_Framework_TestCase {
    public function testIze() {
        echo Color::ize('Can we #{color}.red #{me}.yellow #{silly}.green up in this') . "\n";
        echo Color::ize('Can we #{color}.red(green,bright) #{me}.yellow #{silly}.green up in this') . "\n";
        echo Color::ize('Can we #{color
            something that spans
    many lines of text}.red(bright) #{me}.yellow #{silly}.green up in this') . "\n";
    }
}

?>

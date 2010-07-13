<?php
/**
 * PHP Console Tools is a console library for PHP
 *
 * PHP versions 5.3
 *
 * @category  ToolsAndUtilities
 * @package   Console
 * @author    James Logsdon <jlogsdon@php.net>
 * @copyright 2010 James Logsdon
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://www.github.com/jlogsdon/php-cli-tools
 */

namespace Console;

/**
 * ANSI console coloring
 *
 * @category  ToolsAndUtilities
 * @package   Console
 * @author    James Logsdon <jlogsdon@php.net>
 * @copyright 2010 James Logsdon
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://www.github.com/jlogsdon/php-cli-tools
 */
class Color {
    static protected $colorCodes = array(
        'color' => array(
            'black'   => 30,
            'red'     => 31,
            'green'   => 32,
            'yellow'  => 33,
            'blue'    => 34,
            'magenta' => 35,
            'cyan'    => 36,
            'white'   => 37
        ),
        'style' => array(
            'bright'     => 1,
            'dim'        => 2,
            'underscore' => 4,
            'blink'      => 5,
            'reverse'    => 7,
            'hidden'     => 8
        ),
        'background' => array(
            'black'   => 40,
            'red'     => 41,
            'green'   => 42,
            'yellow'  => 43,
            'blue'    => 44,
            'magenta' => 45,
            'cyan'    => 46,
            'white'   => 47
        )
    );

    /**
     * Returns a string that initiates a color.
     *
     * @param array color the color details (color, background, style)
     *
     * @return string the ansi codes
     */
    static public function colorCode($color) {
        if (!is_array($color)) {
            $color = compact('color');
        }

        $default = array('color' => null, 'style' => null, 'background' => null);
        $color += $default;

        if ($color['color'] == 'reset') {
            return "\033[0m";
        }

        $colors = array();
        foreach (array_keys($default) as $type) {
            $name = $color[$type];
            if (isset(static::$colorCodes[$type][$name])) {
                $colors[] = static::$colorCodes[$type][$name];
            }
        }

        if (empty($colors)) {
            $colors[] = 0;
        }

        return "\033[" . join(';', $colors) . "m";
    }

    /**
     * Colorizes a string and replaces parameters.
     *
     * @param string $str the string to colorize
     *
     * @return string the colorized string
     */
    static public function ize($str) {
        $pattern = '#{(?P<text>.*?)}';
        $pattern.= '\.(?P<color>[a-zA-Z]+)';
        $pattern.= '(\((?P<args>[a-zA-Z,]+)\))?';

        if (!preg_match_all('/' . $pattern . '/ms', $str, $matches, PREG_SET_ORDER)) {
            return $str;
        }

        foreach ($matches as $match) {
            $color = array('color' => $match['color']);

            if (!empty($match['args'])) {
                $args = strpos($match['args'], ',') ? explode(',', $match['args']) : array($match['args']);

                while ($arg = strtolower(trim(array_shift($args)))) {
                    if (isset(static::$colorCodes['background'][$arg])) {
                        $color['background'] = $arg;
                    } else if (isset(static::$colorCodes['style'][$arg])) {
                        $color['style'] = $arg;
                    }
                }
            }

            $parsed = static::colorCode($color) . $match['text'] . static::colorCode('reset');
            $str = str_replace($match[0], $parsed, $str);
        }

        return $str;
    }
}

?>


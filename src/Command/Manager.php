<?php
/**
 * Console utilities
 *
 * PHP versions 5
 *
 * @category  Console
 * @package   Console
 * @author    James Logsdon <jlogsdon@php.net>
 * @copyright 2010 James Logsdon
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://www.github.com/jlogsdon/php-cli-tools
 */

namespace Console\Command;

/**
 * Console command manager
 *
 * @category  Console
 * @package   Console
 * @author    James Logsdon <jlogsdon@php.net>
 * @copyright 2010 James Logsdon
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://www.github.com/jlogsdon/php-cli-tools
 */
class Manager {
    // Protected properties {{{

    protected $_classifier;

    protected $_locator;

    protected $_namespace;

    protected $_path;

    // }}}
    // __construct() {{{

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct() {
        $this->_locator = array($this, 'locator');
        $this->_classifier = array($this, 'classifier');
    }

    // }}}
    // setNamespace() {{{

    /**
     * Sets the namespace prefix for commands.
     *
     * @param string $ns the namespace prefix
     *
     * @return void
     */
    public function setNamespace($ns) {
        $this->_namespace = $ns;
    }

    // }}}
    // setPath() {{{

    /**
     * Sets the directory path for commands.
     *
     * @param string $path the directory path
     *
     * @return void
     * @throws InvalidArgumentException if path is not a directory
     */
    public function setPath($path) {
        if (!is_dir($path)) {
            throw new \InvalidArgumentException("path not found: {$path}");
        }

        $this->_path = $path;
    }

    // }}}
    // setLocator() {{{

    /**
     * Sets the callback used to locate a command file. The callback should
     * accept the command name as an argument and return a file path.
     *
     * @param callback $locator the callback to use when locating a command
     *
     * @return void
     * @throws InvalidArgumentException if the given $locator is not a valid callback
     */
    public function setLocator($locator) {
        if (!is_callable($locator)) {
            throw new \InvalidArgumentException('must be a valid callback');
        }

        $this->_locator = $locator;
    }

    // }}}
    // setClassifier {{{

    /**
     * Sets the callback used to locate a command class. The callback should
     * accept the command name as an argument and return a class name.
     *
     * @param callback $classifier the callback to use when classifying a command
     *
     * @return void
     * @throws InvalidArgumentException if the given $classifier is not a valid callback
     */
    public function setClassifier($classifier) {
        if (!is_callable($classifier)) {
            throw new \InvalidArgumentException('must be a valid callback');
        }

        $this->_classifier = $classifier;
    }

    // }}}
    // classify() {{{

    /**
     * Proxy to our classifier callback.
     *
     * @param string $command name of the command to classify
     *
     * @return string class name of the command
     */
    public function classify($command) {
        return call_user_func($this->_classifier, $command);
    }

    // }}}
    // locate() {{{

    /**
     * Proxy to our locator callback.
     *
     * @param string $command name of the command to locate
     *
     * @return string path to the command file
     */
    public function locate($command) {
        $file = call_user_func($this->_locator, $command);

        if (!is_file($file)) {
            throw new \Exception("unable to locate command: {$command}");
        }

        return $file;
    }

    // }}}
    // load() {{{

    /**
     * Locate and load a command.
     *
     * @param string $command name of the command to load
     *
     * @return Console\Command the command object
     */
    public function load($command) {
        $file = $this->locate($command);
        $class = $this->classify($command);

        include_once $file;
        return new $class;
    }

    // }}}
    // classifier() {{{

    /**
     * Transforms a command name into a class name.
     *
     * @param string $command name of the command to transform
     *
     * @return string class name for the command
     */
    public function classifier($command) {
        return $this->_namespace . '\\' . $command;
    }

    // }}}
    // locator() {{{

    /**
     * Locates a command file.
     *
     * @param string $command name of the command to locate
     *
     * @return string path to the command file
     */
    public function locator($command) {
        return $this->_path . DIRECTORY_SEPARATOR . $command . '.php';
    }

    // }}}
}

?>

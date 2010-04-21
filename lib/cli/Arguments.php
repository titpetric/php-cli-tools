<?php
/**
 * PHP Command Line Tools
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 *
 * @author    James Logsdon <dwarf@girsbrain.org>
 * @copyright 2010 James Logsdom (http://girsbrain.org)
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 */

namespace cli;

/**
 * Parses command line arguments.
 */
class Arguments {
	protected $_flags = array();
	protected $_options = array();
	protected $_enableHelp = true;
	protected $_strict = false;

	/**
	 * Initializes the argument parser. If you wish to change the default behaviour
	 * you may pass an array of options as the first argument. Valid options are
	 * `'help'` and `'strict'`, each a boolean.
	 *
	 * `'help'` is `true` by default, `'strict'` is false by default.
	 *
	 * @param  array  $options  An array of options for this parser.
	 */
	public function __construct($options = array()) {
		$options += array('help' => true, 'strict' => false);

		$this->setHelp($options['help']);
		$this->setStrict($options['strict']);
	}

	/**
	 * Adds a flag (boolean argument) to the argument list.
	 *
	 * @param mixed  $flag  A string representing the flag, or an array of strings.
	 * @param bool   $default  The default value for this flag.
	 * @param string $description  A description to display on the help screen.
	 * @return void
	 */
	public function addFlag($flag, $default = false, $description = null) {
		// Flags can only be a boolean value
		$default = (bool)$default;

		$this->_flags[] = compact('flag', 'default', 'description');
	}

	/**
	 * Adds an option (string argument) to the argument list.
	 *
	 * @param mixed  $flag  A string representing the option, or an array of strings.
	 * @param bool   $default  The default value for this option.
	 * @param string $description  A description to display on the help screen.
	 * @return void
	 */
	public function addOption($option, $default = null, $description = null) {
		$this->_options[] = compact('option', 'default', 'description');
	}

	/**
	 * Enable or disable strict mode. If strict mode is active any invalid
	 * arguments found by the parser will throw an `InvalidArgumentException`.
	 *
	 * Even if strict is disabled, invalid arguments are logged and can be
	 * retrieved with `cli\Arguments::getInvalidArguments()`.
	 *
	 * @param bool  $strict  True to enable, false to disable.
	 * @return void
	 */
	public function setStrict($strict) {
		$this->_strict = (bool)$strict;
	}

	/**
	 * Enable or disable the generated help screen. If enabled, the flags `-h`
	 * and `--help` will halt execution of the script and display a help screen
	 * generated from the descriptions of each flag and option.
	 *
	 * *Note: with this option active, you cannot add the flags `-h` or
	 * `--help`; they will be ignored.*
	 *
	 * @param bool  $help  True to enable, false to disable.
	 * @return void
	 */
	public function setHelp($help) {
		$this->_enableHelp = (bool)$help;
	}

	/**
	 * Parses the argument list with the given options. The returned argument list
	 * will use either the first long name given or the first name in the list
	 * if a long name is not given.
	 *
	 * @return array  The list of parsed arguments.
	 */
	public function parse() {
		$arguments = array();

		return $arguments;
	}
}

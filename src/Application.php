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

namespace Console;

use Console\Command\Manager;

/**
 * Console application
 *
 * @category  Console
 * @package   Console
 * @author    James Logsdon <jlogsdon@php.net>
 * @copyright 2010 James Logsdon
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://www.github.com/jlogsdon/php-cli-tools
 */
class Application {
    // Protected properties {{{

    /**
     * Command manager
     *
     * @var Console\Command\Manager
     */
    protected $_manager;

    // }}}
    // getCommandManager() {{{

    public function getCommandManager() {
        if (empty($this->_manager)) {
            $this->_manager = new Manager();
        }

        return $this->_manager;
    }

    // }}}
    // setCommandManager() {{{

    public function setCommandManager(Manager $manager) {
        $this->_manager = $manager;
    }

    // }}}
    // __get() {{{

    public function __get($prop) {
        switch ($prop) {
        case 'manager':
            return $this->getCommandManager();
        }
    }

    // }}}
    // run() {{{

    public function run() {
        while (true) {
            echo '> ';
            $cmd = trim(fgets(STDIN));
            $cmd = $this->manager->load($cmd);
            $cmd->main();
        }
    }

    // }}}
}

?>

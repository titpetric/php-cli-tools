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

/**
 * Console command
 *
 * @category  Console
 * @package   Console
 * @author    James Logsdon <jlogsdon@php.net>
 * @copyright 2010 James Logsdon
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://www.github.com/jlogsdon/php-cli-tools
 */
abstract class Command {
    // main() {{{

    /**
     * Default command run when no sub-command is called. This command displays
     * a list of available sub-commands.
     *
     * @return void
     */
    public function main() {
        echo "Main Command. override the main() method to change it.\n";
    }

    // }}}
}

?>

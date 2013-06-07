PHP Command Line Tools
======================

A collection of functions and classes to assist with command line development.

Requirements

 * PHP >= 5.3
 * [git_hooks](https://github.com/titpetric/git_hooks) - optional, for some git hooks
 * [phpunit](https://github.com/sebastianbergmann/phpunit/) - optional, for running tests

If you can, please use composer to install and use php-cli-tools.

Run `composer require titpetric/php-cli-tools` to get started. Stability `dev-master` should be ok.


Function List
-------------

 * `\cli\out($msg, ...)`
 * `\cli\out_padded($msg, ...)`
 * `\cli\err($msg, ...)`
 * `\cli\line($msg = '', ...)`
 * `\cli\input()`
 * `\cli\prompt($question, $default = false, $marker = ':')`
 * `\cli\choose($question, $choices = 'yn', $default = 'n')`
 * `\cli\menu($items, $default = false, $title = 'Choose an Item')`


Progress Indicators
-------------------

 * `\cli\notifier\Dots($msg, $dots = 3, $interval = 100)`
 * `\cli\notifier\Spinner($msg, $interval = 100)`
 * `\cli\progress\Bar($msg, $total, $interval = 100)`


Tabular Display
---------------

 * `\cli\Table::__construct(array $headers = null, array $rows = null)`
 * `\cli\Table::setHeaders(array $headers)`
 * `\cli\Table::setRows(array $rows)`
 * `\cli\Table::setRenderer(\cli\table\Renderer $renderer)`
 * `\cli\Table::addRow(array $row)`
 * `\cli\Table::sort($column)`
 * `\cli\Table::display()`

The display function will detect if output is piped and, if it is, render a tab delimited table instead of the ASCII
table rendered for visual display.

You can also explicitly set the renderer used by calling `\cli\Table::setRenderer()` and giving it an instance of one
of the concrete `\cli\table\Renderer` classes.


Argument Parser
---------------

Argument parsing uses a simple framework for taking a list of command line arguments,
usually straight from `$_SERVER['argv']`, and parses the input against a set of
defined rules.


Usage
-----

Check `examples/` folder for various examples. Also check out tests if you want to see
how some features actually work and are used.


Todo
----

 * Expand this README
 * Add doc blocks to rest of code
 * Increase code coverage with phpunit tests

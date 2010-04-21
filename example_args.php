<?php

if (php_sapi_name() != 'cli') {
	die('Must run from command line');
}

require 'lib/cli/cli.php';
\cli\register_autoload();

$arguments = new \cli\Arguments();

$arguments->addFlag('v', false, 'Turn on verbose output');
$arguments->addFlag('version', false, 'Output the version screen');
$arguments->addFlag('q', false, 'Disable all output');

$arguments->addOption(array('C', 'cache'), __DIR__, 'Set the cache directory. Defaults to the current directory');
$arguments->addOption(array('n', 'name'), null, 'Set a name.');

print_r($arguments->parse());

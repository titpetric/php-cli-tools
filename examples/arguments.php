<?php
/**
 * Sample invocations:
 *
 *     # php example_args.php -vC ./ --version
 *     {"verbose":true,"cache":".\/","version":true}
 *     # php example_args.php -vC --version
 *     PHP Warning:  [cli\Arguments] no value given for -C
 *     # php example_args.php -vC multi word --version
 *     {"verbose":true,"cache":"multi word","version":true}
 *
 */

require 'common.php';

$strict = in_array('--strict', $_SERVER['argv']);
if ($strict) {
	unset($_SERVER['argv'][array_search("--strict", $_SERVER['argv'])]);
}

$arguments = new \cli\Arguments(compact('strict'));

$arguments->addFlag(array('verbose', 'v'), 'Turn on verbose output');
$arguments->addFlag('version', 'Turn on verbose output');
$arguments->addFlag(array('quiet', 'q'), 'Disable all output');

$arguments->addOption(array('cache', 'C'), array(
	'default'     => __DIR__,
	'description' => 'Set the cache directory. Defaults to the current directory'));
$arguments->addOption(array('name', 'n'), array(
	'default'     => null, 
	'description' => 'Set a name.'));

$arguments->parse();
echo $arguments->asJSON() . "\n";

<?php

include("vendor/autoload.php");

error_reporting(-1);

$args = new \cli\Arguments(array(
	'flags' => array(
		'verbose' => array(
			'description' => 'Turn on verbose mode',
			'aliases'     => array('v')
		),
		'c' => array(
			'description' => 'A counter to test stackable',
			'stackable'   => true
		)
	),
	'options' => array(
		'user' => array(
			'description' => 'Username for authentication',
			'aliases'     => array('u')
		)
	),
	'strict' => true
));

try {
    $args->parse();
} catch (\cli\arguments\InvalidArguments $e) {
    echo $e->getMessage() . "\n\n";
}

print_r($args->getArguments());

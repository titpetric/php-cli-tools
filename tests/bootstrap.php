<?php

require dirname(__DIR__) . '/src/ClassLoader.php';
$loader = new \Console\ClassLoader();
$loader->register();

require __DIR__ . '/mocks/TestStream.php';

?>

<?php

/**
 * Load applicatino classes and libraries, 
 * as well as 3rd party vendor libraries
 */

use PhpStandard\Autoloader\Autoloader;

// Load vendors
require_once __DIR__ . "/../vendor/autoload.php";

// Instantiate the loader
$loader = new Autoloader();

// Add namespaces to autoload
$loader->appendNamespace(null, __DIR__ . "/../src"); # Root source

// Register the autoloader
$loader->register();

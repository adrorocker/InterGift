<?php
$root = dirname(__DIR__);

require $root.'/vendor/autoload.php';

use Intergift\Application;
use Intergift\Root;

(new Application(Root::instance($root)))->run();

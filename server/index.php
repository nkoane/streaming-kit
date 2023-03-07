<?php

include realpath(__DIR__ . "/vendor/autoload.php");

use Rebirth\Stream\App;

(new App())->getServer()->run();

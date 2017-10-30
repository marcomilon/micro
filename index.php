<?php

require 'vendor/autoload.php';

use micro\Application;

$_GET['r'] = "tete/test";
$app = new Application();
$app->run($_GET);
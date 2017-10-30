<?php

require 'vendor/autoload.php';

use Micro\Application;

$_GET['r'] = "/test";
$app = new Application();
$app->run($_GET);
<?php

require_once("Main.php");

$main = new Main;

error_reporting(E_ALL);
ini_set('display_errors', 'On');
$main->generateHTML();
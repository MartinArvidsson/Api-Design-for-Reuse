<?php
session_start();
require_once("Main.php");

$main = new Main();

error_reporting(E_ALL);
ini_set('display_errors', 'On');
echo '<!DOCTYPE html>
          <html>
            <head>
              <meta charset="utf-8">
              <title>API example</title>
            </head>
            <body>
            '.$main->generateform().'
            </body>
          </html>
';
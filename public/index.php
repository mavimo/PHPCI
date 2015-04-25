<?php
/**
* PHPCI - Continuous Integration for PHP
*
* @copyright    Copyright 2014, Block 8 Limited.
* @license      https://github.com/Block8/PHPCI/blob/master/LICENSE.md
* @link         https://www.phptesting.org/
*/

session_start();

require_once('../bootstrap.php');

$fc = new PHPCI\Application($config, new b8\Http\Request());
print $fc->handleRequest();

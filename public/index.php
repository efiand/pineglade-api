<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once('../utils.php');

if ($_SERVER['REQUEST_URI'] === '/') {
	response(['index' => true]);
}

$APP = '.' . $_SERVER['REQUEST_URI'] . '/index.php';
if (!file_exists($APP)) {
	response(['error' => 'No endpoint ' . $_SERVER['REQUEST_URI']], false);
}

require_once($APP);

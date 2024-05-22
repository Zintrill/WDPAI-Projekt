<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'],'/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('index', 'DefaultController');
Routing::get('dashboard', 'DefaultController');
Routing::get('snmp', 'DefaultController');
Routing::get('configuration', 'DefaultController');
Routing::get('users', 'DefaultController');

Routing::post('login', 'SecurityController');

Routing::run($path);
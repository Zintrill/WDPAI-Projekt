<?php
// Konfiguracja sesji
ini_set('session.cookie_lifetime', 3600);

session_start();

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('index', 'DefaultController');
Routing::get('dashboard', 'DefaultController');
Routing::get('snmp', 'DefaultController');
Routing::get('configuration', 'DefaultController');
Routing::get('users', 'DefaultController');
Routing::get('getUsers', 'UserController'); // Nowa trasa

Routing::post('login', 'SecurityController');
Routing::post('logout', 'SecurityController');
Routing::post('addUser', 'UserController'); // Nowa trasa

Routing::run($path);
?>

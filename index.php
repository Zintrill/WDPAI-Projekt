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
Routing::get('getUsers', 'UserController');
Routing::get('checkUsername', 'UserController');
Routing::get('checkEmail', 'UserController');
Routing::get('getUserById', 'UserController');

Routing::post('updateUser', 'UserController');
Routing::post('login', 'SecurityController');
Routing::post('logout', 'SecurityController');
Routing::post('addUser', 'UserController');
Routing::post('deleteUser', 'UserController');

// Nowe trasy dla urządzeń SNMP
Routing::get('getDevices', 'DeviceController');
Routing::get('getDeviceById', 'DeviceController');
Routing::get('getDeviceTypes', 'DeviceController');
Routing::get('getSnmpVersions', 'DeviceController');
Routing::get('checkDeviceName', 'DeviceController'); 
Routing::get('checkAddressIp', 'DeviceController'); 

Routing::post('addDevice', 'DeviceController');
Routing::post('updateDevice', 'DeviceController');
Routing::post('deleteDevice', 'DeviceController');
Routing::get('getDevicesWithStatus', 'DeviceController'); // Nowa trasa do pobierania urządzeń ze statusem

Routing::run($path);
?>

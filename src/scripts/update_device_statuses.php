<?php

require_once __DIR__.'/../repository/DeviceRepository.php';
require_once __DIR__.'/../repository/Repository.php';
require_once __DIR__.'/../../config.php';
require_once __DIR__.'/../../database.php';

function pingDevice($ip) {
    $output = [];
    $result = exec("ping -c 1 " . escapeshellarg($ip), $output, $status);
    return $status === 0 ? 'online' : 'offline';
}

function getMacAddress($ip, $community, $username = null, $password = null) {
    $oid = "1.3.6.1.2.1.2.2.1.6";
    $session = new SNMP(SNMP::VERSION_2c, $ip, $community);
    try {
        $mac = $session->get($oid);
        $session->close();
        return snmp2_mac($mac);
    } catch (Exception $e) {
        return 'unknown';
    }
}

function snmp2_mac($snmpString) {
    $mac = str_replace('Hex-STRING: ', '', $snmpString);
    $macArray = explode(' ', $mac);
    $macAddress = implode(':', $macArray);
    return $macAddress;
}

function updateDeviceStatus($pdo, $deviceId, $status, $macAddress) {
    $stmt = $pdo->prepare('
        INSERT INTO device_status (device_id, status, mac_address)
        VALUES (:device_id, :status, :mac_address)
        ON CONFLICT (device_id) 
        DO UPDATE SET status = EXCLUDED.status, mac_address = EXCLUDED.mac_address
    ');
    $stmt->bindParam(':device_id', $deviceId, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':mac_address', $macAddress, PDO::PARAM_STR);
    $stmt->execute();
    error_log("Updated device status for device ID: $deviceId");
}

function updateAllDeviceStatuses($pdo) {
    $stmt = $pdo->query('SELECT id, address_ip, snmp_version_id, username, password FROM device');
    $devices = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($devices as $device) {
        $status = pingDevice($device['address_ip']);
        $macAddress = getMacAddress($device['address_ip'], 'public', $device['username'], $device['password']);
        updateDeviceStatus($pdo, $device['id'], $status, $macAddress);
    }
}

// Tworzenie instancji bazy danych i uzyskiwanie połączenia
$database = new Database();
$pdo = $database->connect();

// Aktualizacja statusu i adresu MAC wszystkich urządzeń
updateAllDeviceStatuses($pdo);
echo "Device statuses updated";

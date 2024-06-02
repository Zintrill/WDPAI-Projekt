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
    $macAddress = 'unknown';

    try {
        $mac = $session->get($oid);
        $session->close();
        $macAddress = snmp2_mac($mac);
    } catch (Exception $e) {
        // Nie można pobrać adresu MAC, urządzenie nie obsługuje SNMP lub wystąpił inny błąd
        error_log("Error while fetching MAC address for $ip: " . $e->getMessage());
    }

    return $macAddress;
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
        DO UPDATE SET status = EXCLUDED.status, mac_address = COALESCE(EXCLUDED.mac_address, device_status.mac_address)
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
        $ip = $device['address_ip'];
        $snmpVersion = $device['snmp_version_id'];
        $status = 'offline';
        $macAddress = 'unknown';

        // Sprawdź status urządzenia przy użyciu pingowania
        $status = pingDevice($ip);

        // Jeśli urządzenie jest online, spróbuj pobrać adres MAC przy użyciu SNMP
        if ($status === 'online' && $snmpVersion !== null) {
            $macAddress = getMacAddress($ip, 'public', $device['username'], $device['password']);
        }

        // Zaktualizuj status urządzenia w bazie danych
        updateDeviceStatus($pdo, $device['id'], $status, $macAddress);
    }
}

// Tworzenie instancji bazy danych i uzyskiwanie połączenia
$database = new Database();
$pdo = $database->connect();

// Aktualizacja statusu i adresu MAC wszystkich urządzeń
updateAllDeviceStatuses($pdo);
echo "Device statuses updated";

?>

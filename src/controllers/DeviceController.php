<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/DeviceRepository.php';

class DeviceController extends AppController
{
    private function checkPermission($requiredRole)
    {
        $userRole = $_SESSION['user_role'];
        if ($userRole > $requiredRole) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['status' => 'error', 'message' => 'Access Denied']);
            exit();
        }
    }

    public function getDevices()
    {
        header('Content-Type: application/json');
        try {
            $deviceRepository = new DeviceRepository();
            $devices = $deviceRepository->getAllDevices();

            echo json_encode($devices);
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getDeviceById()
    {
        header('Content-Type: application/json');
        try {
            if ($this->isGET()) {
                $deviceId = $_GET['id'];
                $deviceRepository = new DeviceRepository();
                $device = $deviceRepository->getDeviceById($deviceId);

                echo json_encode($device);
            } else {
                throw new Exception('Invalid request method');
            }
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getDeviceTypes()
    {
        header('Content-Type: application/json');
        try {
            $deviceRepository = new DeviceRepository();
            $types = $deviceRepository->getDeviceTypes();

            echo json_encode($types);
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getSnmpVersions()
    {
        header('Content-Type: application/json');
        try {
            $deviceRepository = new DeviceRepository();
            $versions = $deviceRepository->getSnmpVersions();

            echo json_encode($versions);
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function checkDeviceName()
    {
        if ($this->isGET()) {
            header('Content-Type: application/json');
            if (isset($_GET['deviceName'])) {
                $deviceName = $_GET['deviceName'];
                $deviceRepository = new DeviceRepository();
                $isTaken = $deviceRepository->isDeviceNameTaken($deviceName);
                echo json_encode(['isTaken' => $isTaken]);
            }
        }
    }

    public function checkAddressIp()
    {
        if ($this->isGET()) {
            header('Content-Type: application/json');
            if (isset($_GET['addressIp'])) {
                $addressIp = $_GET['addressIp'];
                $deviceRepository = new DeviceRepository();
                $isTaken = $deviceRepository->isAddressIpTaken($addressIp);
                echo json_encode(['isTaken' => $isTaken]);
            }
        }
    }

    private function isValidIpAddress($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }

    public function addDevice()
    {
        $this->checkPermission(1); // Tylko administrator
        header('Content-Type: application/json');
        try {
            if ($this->isPost()) {
                $deviceRepository = new DeviceRepository();

                $deviceName = $_POST['deviceName'];
                $deviceType = $_POST['deviceType'];
                $deviceAddress = $_POST['deviceAddress'];
                $snmpVersion = $_POST['snmpVersion'];
                $userName = $_POST['userName'] ?? '';
                $password = $_POST['password'] ?? '';
                $description = $_POST['description'] ?? '';

                if ($deviceRepository->isDeviceNameTaken($deviceName)) {
                    echo json_encode(['status' => 'error', 'message' => 'Device name is already taken']);
                    return;
                }

                if ($deviceRepository->isAddressIpTaken($deviceAddress)) {
                    echo json_encode(['status' => 'error', 'message' => 'Address IP is already taken']);
                    return;
                }

                if (!$this->isValidIpAddress($deviceAddress)) {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid IP address format']);
                    return;
                }

                $deviceRepository->addDevice($deviceName, $deviceType, $deviceAddress, $snmpVersion, $userName, $password, $description);

                echo json_encode(['status' => 'success']);
            } else {
                throw new Exception('Invalid request method');
            }
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function deleteDevice()
    {
        $this->checkPermission(1); // Tylko administrator
        header('Content-Type: application/json');
        try {
            if ($this->isPost()) {
                $deviceId = $_POST['deviceId'];
                $deviceRepository = new DeviceRepository();
                $deviceRepository->deleteDevice($deviceId);

                echo json_encode(['status' => 'success']);
            } else {
                throw new Exception('Invalid request method');
            }
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updateDevice()
    {
        $this->checkPermission(2); // Administrator i technik
        header('Content-Type: application/json');
        try {
            if ($this->isPost()) {
                $deviceRepository = new DeviceRepository();

                $deviceId = $_POST['deviceId'];
                $deviceName = $_POST['deviceName'];
                $deviceType = $_POST['deviceType'];
                $deviceAddress = $_POST['deviceAddress'];
                $snmpVersion = $_POST['snmpVersion'];
                $userName = $_POST['userName'];
                $password = $_POST['password'];
                $description = $_POST['description'];

                $currentDevice = $deviceRepository->getDeviceById($deviceId);

                // Sprawdź, czy nazwa urządzenia została zmieniona i czy nowa nazwa jest zajęta
                if ($currentDevice['device_name'] !== $deviceName && $deviceRepository->isDeviceNameTaken($deviceName)) {
                    echo json_encode(['status' => 'error', 'message' => 'Device name is already taken']);
                    return;
                }

                // Sprawdź, czy adres IP został zmieniony i czy nowy adres jest zajęty
                if ($currentDevice['address_ip'] !== $deviceAddress && $deviceRepository->isAddressIpTaken($deviceAddress)) {
                    echo json_encode(['status' => 'error', 'message' => 'Address IP is already taken']);
                    return;
                }

                if (!$this->isValidIpAddress($deviceAddress)) {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid IP address format']);
                    return;
                }

                $deviceRepository->updateDevice($deviceId, $deviceName, $deviceType, $deviceAddress, $snmpVersion, $userName, $password, $description);

                // Zaktualizuj status urządzenia
                $this->updateSingleDeviceStatus($deviceId, $deviceAddress, $snmpVersion, $userName, $password);

                echo json_encode(['status' => 'success']);
            } else {
                throw new Exception('Invalid request method');
            }
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function pingDevice($ip)
    {
        $pingResult = shell_exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($ip)));
        if (strpos($pingResult, '1 packets received') !== false) {
            return true;
        } else {
            return false;
        }
    }

    private function checkSNMP($ip, $version, $userName, $password)
{
    $versionFlag = '';
    switch ($version) {
        case '1':
            $versionFlag = '1';
            break;
        case '2':
            $versionFlag = '2c';
            break;
        case '3':
            $versionFlag = '3';
            break;
    }

    $communityString = ($version === '3') ? "$userName:$password" : 'public';
    //$command = sprintf('snmpwalk -v %s -c %s %s 1.3.6.1.2.1.1.1.0', escapeshellarg($versionFlag), escapeshellarg($communityString), escapeshellarg($ip));
    //$snmpResult = shell_exec($command);
    
    //error_log("SNMP Command: $command");
    //error_log("SNMP Result: $snmpResult");

    //return strpos($snmpResult, 'Timeout') === false;
}

private function updateSingleDeviceStatus($deviceId, $deviceAddress, $snmpVersion, $userName, $password)
{
    $deviceRepository = new DeviceRepository();
    $status = 'Offline';
    $macAddress = 'N/A';

    if ($snmpVersion == '4') { // ID 4 to ICMP
        $isReachable = $this->pingDevice($deviceAddress);
        $status = $isReachable ? 'Online' : 'Offline';
    } else {
        $isReachable = $this->checkSNMP($deviceAddress, $snmpVersion, $userName, $password);
        $status = $isReachable ? 'Online' : 'Offline';
        if ($isReachable) {
            //$macAddress = $this->getMacAddress($deviceAddress, $snmpVersion, $userName, $password);
        }
    }

    $deviceRepository->updateDeviceStatus($deviceId, $status, $macAddress);
}

public function updateDeviceStatuses()
{
    header('Content-Type: application/json');
    try {
        $deviceRepository = new DeviceRepository();
        $devices = $deviceRepository->getAllDevices();

        foreach ($devices as $device) {
            $this->updateSingleDeviceStatus(
                $device['id'],
                $device['address_ip'],
                $device['snmp_version'],
                $device['username'],
                $device['password']
            );
        }

        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        error_log($e->getMessage(), 0);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

/*private function getMacAddress($ip, $version, $userName, $password)
{
    $versionFlag = '';
    switch ($version) {
        case '1':
            $versionFlag = '1';
            break;
        case '2':
            $versionFlag = '2c';
            break;
        case '3':
            $versionFlag = '3';
            break;
    }

    $communityString = ($version === '3') ? "$userName:$password" : 'public';
    $command = sprintf('snmpget -v %s -c %s %s 1.3.6.1.2.1.2.2.1.6.2', escapeshellarg($versionFlag), escapeshellarg($communityString), escapeshellarg($ip));
    $snmpResult = shell_exec($command);
    
    error_log("SNMP Command: $command");
    error_log("SNMP Result: $snmpResult");

    preg_match('/([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}/', $snmpResult, $matches);
    return $matches[0] ?? 'N/A';
}*/


}

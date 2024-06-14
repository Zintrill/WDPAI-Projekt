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
            
            foreach ($devices as &$device) {
                $snmpVersion = $deviceRepository->getSnmpVersionByDeviceId($device['id']);
                $device['snmp_version'] = $snmpVersion['snmp_version'];
            }

            echo json_encode($devices);
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function addDevice()
    {
        $this->checkPermission(2);
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

    public function updateDevice()
    {
        $this->checkPermission(2);
        header('Content-Type: application/json');
        try {
            if ($this->isPost()) {
                $deviceRepository = new DeviceRepository();

                $deviceId = $_POST['deviceId'];
                $deviceName = $_POST['deviceName'];
                $deviceType = $_POST['deviceType'];
                $deviceAddress = $_POST['deviceAddress'];
                $snmpVersion = $_POST['snmpVersion'];
                $userName = $_POST['userName'] ?? '';
                $password = $_POST['password'] ?? '';
                $description = $_POST['description'] ?? '';

                $currentDevice = $deviceRepository->getDeviceById($deviceId);

                if ($currentDevice['device_name'] !== $deviceName && $deviceRepository->isDeviceNameTaken($deviceName)) {
                    echo json_encode(['status' => 'error', 'message' => 'Device name is already taken']);
                    return;
                }

                if ($currentDevice['address_ip'] !== $deviceAddress && $deviceRepository->isAddressIpTaken($deviceAddress)) {
                    echo json_encode(['status' => 'error', 'message' => 'Address IP is already taken']);
                    return;
                }

                if (!$this->isValidIpAddress($deviceAddress)) {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid IP address format']);
                    return;
                }

                $deviceRepository->updateDevice($deviceId, $deviceName, $deviceType, $deviceAddress, $snmpVersion, $userName, $password, $description);

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
        $this->checkPermission(2);
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

    public function getSnmpVersionByDeviceId()
    {
        header('Content-Type: application/json');
        try {
            if ($this->isGET()) {
                $deviceId = $_GET['id'];
                $deviceRepository = new DeviceRepository();
                $snmpVersion = $deviceRepository->getSnmpVersionByDeviceId($deviceId);
                echo json_encode($snmpVersion);
            } else {
                throw new Exception('Invalid request method');
            }
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getDeviceStatuses()
    {
        header('Content-Type: application/json');
        try {
            $deviceRepository = new DeviceRepository();
            $statuses = $deviceRepository->getDeviceStatuses();
            echo json_encode($statuses);
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getDeviceStatusesByType()
    {
        header('Content-Type: application/json');
        try {
            $deviceRepository = new DeviceRepository();
            $statuses = $deviceRepository->getDeviceStatusesByType();
            echo json_encode($statuses);
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

    public function checkAndUpdateDeviceStatuses()
    {
        header('Content-Type: application/json');
        try {
            $deviceRepository = new DeviceRepository();
            $devices = $deviceRepository->getAllDevices();

            foreach ($devices as $device) {
                $status = 'Offline';
                $macAddress = 'N/A';
                $isReachable = false;

                if (isset($device['snmp_version_id']) && $device['snmp_version_id'] == 4) {
                    $isReachable = $this->pingDevice($device['address_ip']);
                    $status = $isReachable ? 'Online' : 'Offline';
                } elseif (isset($device['snmp_version_id'])) {
                    $isReachable = $this->checkSNMP($device['address_ip'], $device['snmp_version_id'], $device['username'], $device['password']);
                    $status = $isReachable ? 'Online' : 'Offline';
                    if ($isReachable) {
                        $macAddress = $this->getMacAddress($device['address_ip'], $device['snmp_version_id'], $device['username'], $device['password']);
                    }
                }

                $deviceRepository->updateDeviceStatus($device['id'], $status, $macAddress);
            }

            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updateDeviceStatuses()
    {
        header('Content-Type: application/json');
        try {
            $deviceRepository = new DeviceRepository();
            $devices = $deviceRepository->getAllDevices();

            foreach ($devices as $device) {
                $status = $this->checkDeviceStatus($device['address_ip'], $device['snmp_version'], $device['username'], $device['password']);
                $deviceRepository->updateDeviceStatus($device['id'], $status['status'], $status['macAddress']);
            }

            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function checkDeviceStatus($ip, $snmpVersion, $username = '', $password = '')
    {
        header('Content-Type: application/json');
        try {
            $deviceRepository = new DeviceRepository();
            $devices = $deviceRepository->getAllDevices();

            foreach ($devices as $device) {
                $status = 'Offline';
                $macAddress = 'N/A';

                if (isset($device['snmp_version_id']) && $device['snmp_version_id'] == 4) {
                    $isReachable = $this->pingDevice($device['address_ip']);
                    $status = $isReachable ? 'Online' : 'Offline';
                } elseif (isset($device['snmp_version_id'])) {
                    $isReachable = $this->checkSNMP($device['address_ip'], $device['snmp_version_id'], $device['username'], $device['password']);
                    $status = $isReachable ? 'Online' : 'Offline';
                    if ($isReachable) {
                        $macAddress = $this->getMacAddress($device['address_ip'], $device['snmp_version_id'], $device['username'], $device['password']);
                    }
                }

                $deviceRepository->updateDeviceStatus($device['id'], $status, $macAddress);
            }

            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function pingDevice($ip)
    {
        $pingResult = shell_exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($ip)));
        if ($pingResult === null) {
            return false;
        }
        return strpos($pingResult, '1 packets received') !== false;
    }
    
    private function checkSNMP($ip, $version, $username = '', $password = '')
    {
        $command = '';
    
        switch ($version) {
            case '1':
                $command = sprintf('snmpwalk -v 1 -c public %s', escapeshellarg($ip));
                break;
            case '2c':
                $command = sprintf('snmpwalk -v 2c -c public %s', escapeshellarg($ip));
                break;
            case '3':
                $command = sprintf('snmpwalk -v 3 -u %s -A %s -l authPriv -a MD5 -x DES %s', escapeshellarg($username), escapeshellarg($password), escapeshellarg($ip));
                break;
        }
    
        $snmpResult = shell_exec($command);
        if ($snmpResult === null) {
            return false;
        }
        return strpos($snmpResult, 'Timeout') === false;
    }

    private function getMacAddress($ip, $version, $username = '', $password = '')
    {
        $command = '';
    
        switch ($version) {
            case '1':
                $command = sprintf('snmpget -v 1 -c public %s 1.3.6.1.2.1.2.2.1.6.2', escapeshellarg($ip));
                break;
            case '2c':
                $command = sprintf('snmpget -v 2c -c public %s 1.3.6.1.2.1.2.2.1.6.2', escapeshellarg($ip));
                break;
            case '3':
                $command = sprintf('snmpget -v 3 -u %s -A %s -l authPriv -a MD5 -x DES %s 1.3.6.1.2.1.2.2.1.6.2', escapeshellarg($username), escapeshellarg($password), escapeshellarg($ip));
                break;
        }
    
        $snmpResult = shell_exec($command);
        preg_match('/([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}/', $snmpResult, $matches);
        return $matches[0] ?? 'N/A';
    }
}

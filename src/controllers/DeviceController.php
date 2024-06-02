<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/DeviceRepository.php';

class DeviceController extends AppController
{
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
        header('Content-Type: application/json');
        try {
            if ($this->isPost()) {
                $deviceRepository = new DeviceRepository();

                $deviceName = $_POST['deviceName'];
                $deviceType = $_POST['deviceType'];
                $deviceAddress = $_POST['deviceAddress'];
                $snmpVersion = $_POST['snmpVersion'];
                $userName = $_POST['userName'];
                $password = $_POST['password'];
                $description = $_POST['description'];

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

    public function updateDeviceStatuses()
    {
        header('Content-Type: application/json');
        try {
            require_once __DIR__.'/../scripts/update_device_statuses.php';
            echo json_encode(['status' => 'success', 'message' => 'Device statuses updated']);
        } catch (Exception $e) {
            error_log($e->getMessage(), 0);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

}

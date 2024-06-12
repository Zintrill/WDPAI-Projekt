<?php

require_once 'Repository.php';

class DeviceRepository extends Repository
{
    public function getAllDevices()
    {
        $stmt = $this->database->connect()->prepare('
            SELECT d.id, d.device_name, t.type, d.address_ip, s.snmp as snmp_version, ds.status, ds.mac_address, d.username, d.password, d.description
            FROM public.device d
            JOIN public.types t ON d.type_id = t.type_id
            JOIN public.snmp_version s ON d.snmp_version_id = s.snmp_version_id
            LEFT JOIN public.device_status ds ON d.id = ds.device_id
        ');
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDeviceById($deviceId)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT d.id, d.device_name, d.type_id, d.address_ip, d.snmp_version_id, ds.status, ds.mac_address, d.username, d.password, d.description
            FROM public.device d
            LEFT JOIN public.device_status ds ON d.id = ds.device_id
            WHERE d.id = :id
        ');
        $stmt->bindParam(':id', $deviceId, PDO::PARAM_INT);
        $stmt->execute();

        $device = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$device) {
            return null;
        }

        return $device;
    }

    public function getDeviceTypes(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT type_id, type
            FROM public.types
        ');
        $stmt->execute();

        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $types;
    }

    public function getSnmpVersions(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT snmp_version_id, snmp
            FROM public.snmp_version
        ');
        $stmt->execute();

        $versions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $versions;
    }

    public function addDevice(string $deviceName, int $typeId, string $addressIp, int $snmpVersionId, string $userName, string $password, ?string $description)
{
    $stmt = $this->database->connect()->prepare('
        INSERT INTO public.device (device_name, type_id, address_ip, snmp_version_id, username, password, description)
        VALUES (:device_name, :type_id, :address_ip, :snmp_version_id, :username, :password, :description)
        RETURNING id
    ');
    $stmt->bindParam(':device_name', $deviceName, PDO::PARAM_STR);
    $stmt->bindParam(':type_id', $typeId, PDO::PARAM_INT);
    $stmt->bindParam(':address_ip', $addressIp, PDO::PARAM_STR);
    $stmt->bindParam(':snmp_version_id', $snmpVersionId, PDO::PARAM_INT);
    $stmt->bindParam(':username', $userName, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);

    $stmt->execute();
    $deviceId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

    // Initialize device status as 'waiting'
    $this->initializeDeviceStatus($deviceId);
}


    public function updateDevice(int $deviceId, string $deviceName, int $typeId, string $addressIp, int $snmpVersionId, string $userName, string $password, ?string $description)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE public.device
            SET device_name = :device_name, type_id = :type_id, address_ip = :address_ip, snmp_version_id = :snmp_version_id, username = :username, password = :password, description = :description
            WHERE id = :id
        ');
        $stmt->bindParam(':device_name', $deviceName, PDO::PARAM_STR);
        $stmt->bindParam(':type_id', $typeId, PDO::PARAM_INT);
        $stmt->bindParam(':address_ip', $addressIp, PDO::PARAM_STR);
        $stmt->bindParam(':snmp_version_id', $snmpVersionId, PDO::PARAM_INT);
        $stmt->bindParam(':username', $userName, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':id', $deviceId, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function deleteDevice(int $deviceId)
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM public.device WHERE id = :id
        ');
        $stmt->bindParam(':id', $deviceId, PDO::PARAM_INT);
        $stmt->execute();
    }
    

    public function isDeviceNameTaken($deviceName)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT COUNT(*) FROM public.device WHERE LOWER(device_name) = LOWER(:device_name)
        ');
        $stmt->bindParam(':device_name', $deviceName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function isAddressIpTaken(string $addressIp): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT COUNT(*) FROM public.device WHERE address_ip = :address_ip
        ');
        $stmt->bindParam(':address_ip', $addressIp, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    public function initializeDeviceStatus(int $deviceId, string $status = 'waiting', string $macAddress = 'N/A')
{
    $stmt = $this->database->connect()->prepare('
        INSERT INTO public.device_status (device_id, status, mac_address)
        VALUES (:device_id, :status, :mac_address)
    ');
    $stmt->bindParam(':device_id', $deviceId, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':mac_address', $macAddress, PDO::PARAM_STR);
    $stmt->execute();
}

public function updateDeviceStatus(int $deviceId, string $status, string $macAddress)
{
    $stmt = $this->database->connect()->prepare('
        UPDATE public.device_status
        SET status = :status, mac_address = :mac_address
        WHERE device_id = :device_id
    ');
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':mac_address', $macAddress, PDO::PARAM_STR);
    $stmt->bindParam(':device_id', $deviceId, PDO::PARAM_INT);
    $stmt->execute();
}
}
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Device implements JsonSerializable
{
    private $devicename;
    private $typeid;
    private $addressip;
    private $snmpversionid;
    private $username;
    private $password;
    private $description;

    public function __construct(string $devicename, int $typeid, string $addressip, int $snmpversionid, string $username, string $password, ?string $description)
    {
        $this->devicename = $devicename;
        $this->typeid = $typeid;
        $this->addressip = $addressip;
        $this->snmpversionid = $snmpversionid;
        $this->username = $username;
        $this->password = $password;
        $this->description = $description;
        
    }

    public function getDeviceName(): string
    {
        return $this->devicename;
    }

    public function setDeviceName(string $devicename)
    {
        $this->devicename = $devicename;
    }

    public function getTypeId(): string
    {
        return $this->typeid;
    }

    public function setTypeId(string $typeid)
    {
        $this->typeid = $typeid;
    }

    public function getaddressip(): string
    {
        return $this->addressip;
    }

    public function setaddressip(string $addressip)
    {
        $this->addressip = $addressip;
    }

    public function getSnmpVersionId(): string
    {
        return $this->snmpversionid;
    }

    public function setSnmpVersionId(string $snmpversionid)
    {
        $this->snmpversionid = $snmpversionid;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function jsonSerialize()
    {
        return [
            'device_name' => $this->devicename,
            'type_id' => $this->typeid,
            'address_ip' => $this->addressip,
            'snmp_version_id' => $this->snmpversionid,
            'username' => $this->username,
            'password' => $this->password,
            'description' => $this->description
        ];
    }
}

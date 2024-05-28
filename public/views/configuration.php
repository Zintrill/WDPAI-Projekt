<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNMP CONFIGURATION</title>
    <link rel="stylesheet" type="text/css" href="public/css/background.css">
    <link rel="stylesheet" type="text/css" href="public/css/configuration-snmp.css">
    <script src="https://kit.fontawesome.com/bb4f511674.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-dash">
        <nav class="top-nav">
            <img class="img-log" src="public/img/logo.svg">
            <ul class="nav-menu">
                <li><a href="dashboard" class="nav-link button"><i class="fa-solid fa-table"></i> Dashboard</a></li>
                <li><a href="snmp" class="nav-link button"><i class="fa-solid fa-desktop"></i> SNMP Overview</a></li>
                <li><a href="configuration" class="nav-link button"><i class="fa-solid fa-wrench"></i> Configuration</a></li>
                <li><a href="users" class="nav-link button"><i class="fa-solid fa-users"></i> Users</a></li>
            </ul>
            <span class="nav-text"><?php echo $username; ?></span>
            <nav class="user-options">
                <div class="options">
                    <button id="userButton"><i class="fa-solid fa-circle-user"></i></button>
                    <ul class="options-menu" id="optionsMenu">
                        <li><a href="#" class="option-button"><i class="fa-solid fa-gear"></i>Options</a></li>
                        <li><a href="#" class="option-button"><i class="fa-solid fa-question"></i>About</a></li>
                        <li>
                            <form action="logout" method="post">
                                <button type="submit" class="option-button"><i class="fa-solid fa-power-off"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </nav>
        <div class="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <div class="page-title"><h1>SNMP Configuration</h1></div>
    </div>

    <div class="container-snmp-devices">
        <div class="snmp-management">
            <button id="addDeviceButton" class="action-button"><i class="fa-solid fa-circle-plus"></i> ADD DEVICE</button>
            <div class="table-header">
                <span class="title">Device Name</span>
                <span class="title">Type</span>
                <span class="title">Address IP</span>
                <span class="title-phone">SNMP Version</span>
                <span class="title-phone">User Name</span>
                <span class="title-phone">Password</span>
                <span class="title-phone">Description</span>
            </div>
            <div id="DeviceList">
                <div class="device-item">
                    <span class="device-info">SW02-Test</span>
                    <span class="device-info">Switch</span>
                    <span class="device-info">192.168.101.1</span>
                    <span class="device-info-phone">SNMP V1</span>
                    <span class="device-info-phone">SNMP controller</span>
                    <span class="device-info-phone">******** <i class="eye-icon fa-solid fa-eye-low-vision"></i></span>
                    <span class="device-info-phone">Biuro w hotrelu</span>
                    <button class="editButton"><i class="fa-solid fa-pencil"></i></button>
                    <button class="deleteButton"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="device-form" id="deviceForm" style="display: none;">
        <form>
            <input type="text" id="deviceName" name="deviceName" placeholder="Device Name">
            <input type="text" id="deviceType" name="deviceType" placeholder="Type">
            <input type="text" id="deviceAddress" name="deviceAddress" placeholder="Address IP">
            <select id="snmpVersion" name="snmpVersion">
                <option value="" disabled selected>SNMP Version</option>
                <option value="v1">SNMP V1</option>
                <option value="v2c">SNMP V2c</option>
                <option value="v3">SNMP V3</option>
            </select>
            <input type="text" id="userName" name="userName" placeholder="User Name">
            <input type="password" id="password" name="password" placeholder="Password">
            <input type="text" id="description" name="description" placeholder="Description">
            <button type="button" class="submit-button" onclick="submitForm()">Submit</button>
            <button type="button" class="add-another-button" onclick="addAnotherDevice()">Add Another Device</button>
            <button type="button" class="cancel-button" id="cancelButton" onclick="cancelForm()">Cancel</button>
        </form>
    </div>
</body>
<script src="public/js/menu.js"></script>
<script src="public/js/options.js"></script>
<script src="public/js/device-form.js"></script>
</html>

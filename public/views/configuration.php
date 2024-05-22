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
                <li><a href="dashboard.html" class="nav-link button"><i class="fa-solid fa-table"></i> Dashboard</a></li>
                <li><a href="snmp.html" class="nav-link button"><i class="fa-solid fa-desktop"></i> SNMP Overview</a></li>
                <li><a href="configuration.html" class="nav-link button"><i class="fa-solid fa-wrench"></i> Configuration</a></li>
                <li><a href="users.html" class="nav-link button"><i class="fa-solid fa-users"></i> Users</a></li>
            </ul>
            <span class="nav-text">name</span>
            
            <nav class="user-options">
                <div class="options">
                    <button id="userButton"><i class="fa-solid fa-circle-user"></i></button>
                    <ul class="options-menu" id="optionsMenu">
                        <li><a href="#" class="option-button"><i class="fa-solid fa-gear"></i>Options</a></li>
                        <li><a href="#" class="option-button"><i class="fa-solid fa-question"></i>About</a></li>
                        <li><a href="login.html" class="option-button"><i class="fa-solid fa-power-off"></i>Logout</a></li>
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
        <script src="public/js/menu.js"></script>
        <script src="public/js/options.js"></script>
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
                    <span class="device-info-phone">SNMP controler</span>
                    <span class="device-info-phone">******** <i class="eye-icon fa-solid fa-eye-low-vision"></i></span>
                    <span class="device-info-phone">Biuro w hotrelu</span>
                    <button class="editButton"><i class="fa-solid fa-pencil"></i></button>
                    <button class="deleteButton"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
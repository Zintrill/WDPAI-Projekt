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
            <div id="DeviceList" class="device-list">
                <!-- Lista urządzeń będzie tutaj -->
            </div>
        </div>
    </div>

    <div id="deviceModal" class="add-modal">
        <div class="modal-content">
            <span class="close-button" id="closeDeviceModal">&times;</span>
            <form id="deviceForm" class="device-form">
                <div class="form-group">
                    <label for="deviceName">Device Name</label>
                    <input type="text" id="deviceName" name="deviceName" placeholder="Device Name" required>
                    <span id="deviceNameError" class="error-message"></span>
                </div>
                <div class="form-group">
                    <label for="deviceType">Type</label>
                    <select id="deviceType" name="deviceType" required>
                        <option value="" disabled selected>Select Type</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deviceAddress">Address IP</label>
                    <input type="text" id="deviceAddress" name="deviceAddress" placeholder="Address IP" required>
                    <span id="deviceAddressError" class="error-message"></span>
                </div>
                <div class="form-group">
                    <label for="snmpVersion">SNMP Version</label>
                    <select id="snmpVersion" name="snmpVersion" required>
                        <option value="" disabled selected>SNMP Version</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="userName">User Name</label>
                    <input type="text" id="userName" name="userName" placeholder="User Name" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" placeholder="Description">
                </div>
                <div class="form-buttons">
                    <button type="button" class="cancel-button" id="cancelDeviceButton">Cancel</button>
                    <button type="submit" class="confirm-button">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="delete-modal">
        <div class="modal-content">
            <span class="close-button" id="closeModal">&times;</span>
            <p>Are you sure you want to delete this device?</p>
            <button id="confirmDeleteButton" class="confirm-button">Yes</button>
            <button id="cancelDeleteButton" class="cancel-button">No</button>
        </div>
    </div>
    
    <script src="public/js/menu.js"></script>
    <script src="public/js/options.js"></script>
    <script src="public/js/device-form.js"></script>
</body>
</html>

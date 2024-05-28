<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNMP OVERVIEW</title>
    <link rel="stylesheet" type="text/css" href="public/css/background.css">
    <link rel="stylesheet" type="text/css" href="public/css/overwiev-snmp.css">
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
        <div class="page-title"><h1>SNMP Overview</h1></div>
        <script src="public/js/menu.js"></script>
        <script src="public/js/options.js"></script>
    </div>
    <div class="container-snmp-devices">
        <div class="snmp-management">
            <div class="table-header">
                <div class="segment">
                    <span class="title" data-sort="asc">
                        Device Name 
                        <i class="fas fa-sort" data-column="device_name"></i>
                    </span>
                </div>
                <div class="segment">
                    <span class="title" data-sort="asc">
                        Address IP 
                        <i class="fas fa-sort" data-column="ip_address"></i>
                    </span>
                </div>
                <div class="segment">
                    <span class="title" data-sort="asc">
                        Address MAC 
                        <i class="fas fa-sort" data-column="mac_address"></i>
                    </span>
                </div>
                <div class="segment">
                    <span class="title" data-sort="asc">
                        Type 
                        <i class="fas fa-sort" data-column="type"></i>
                    </span>
                </div>
                <div class="segment">
                    <span class="title" data-sort="asc">
                        Status 
                        <i class="fas fa-sort" data-column="status"></i>
                    </span>
                </div>
                <div class="segment">
                    <span class="title" data-sort="asc">UP Time <i class="fas fa-sort" data-column="uptime"></i></span>
                </div>
                <div class="segment">
                    <span class="title-phone">Actions</span>
                </div>
                    <div class="segment">
                        <input type="text" class="search-input" data-column="device_name" placeholder="Search Device Name...">
                    </div>
                    <div class="segment">
                        <input type="text" class="search-input" data-column="ip_address" placeholder="Search Address IP...">
                    </div>
                    <div class="segment">
                        <input type="text" class="search-input" data-column="mac_address" placeholder="Search Address MAC...">
                    </div>
                    <div class="segment">
                        <select class="filter-select" data-column="type">
                            <option value="">All</option>
                            <option value="Switch">Switch</option>
                            <option value="Router">Router</option>
                            <!-- Dodaj więcej opcji według potrzeb -->
                        </select>
                    </div>
                    <div class="segment">
                        <select class="filter-select" data-column="status">
                            <option value="">All</option>
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
                            <!-- Dodaj więcej opcji według potrzeb -->
                        </select>
                    </div>
                    <div class="segment"></div>
                    <div class="segment"></div>
            </div>
            
            <div id="DeviceList">
                <div class="device-item">
                    <span class="device-info">SW02-Test</span>
                    <span class="device-info">Online</span>
                    <span class="device-info">Switch</span>
                    <span class="device-info-phone">192.168.101.1</span>
                    <span class="device-info-phone">00:15:5D:1A:76:8C</span>
                    <span class="device-info-phone">12D 12H</span>
                    <button class="ellipsisButton"><i class="fa-solid fa-ellipsis"></i></button>
                </div>
            </div>
           
        </div>
    </div>
</body>
</html>

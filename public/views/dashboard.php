<!DOCTYPE html>
<html lang="en">
<head>
    <title>DASHBOARD</title>
    <link rel="stylesheet" type="text/css" href="public/css/background.css">
    <link rel="stylesheet" type="text/css" href="public/css/dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-streaming/2.0.0/chartjs-plugin-streaming.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <span class="nav-text">name</span>
        <nav class="user-options">
            <div class="options">
                <button id="userButton"><i class="fa-solid fa-circle-user"></i></button>
                <ul class="options-menu" id="optionsMenu">
                    <li><a href="#" class="option-button"><i class="fa-solid fa-gear"></i>Options</a></li>
                    <li><a href="#" class="option-button"><i class="fa-solid fa-question"></i>About</a></li>
                    <li><a href="login" class="option-button"><i class="fa-solid fa-power-off"></i>Logout</a></li>
                </ul>
            </div>
        </nav>
    </nav>
    <div class="hamburger">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
    <div class="page-title"><h1>Dashboard</h1></div>
        <div class="container-main">
            <div class="alerts-buttons">
                <button class="button warning-button">
                    <div><i class="fa-solid fa-exclamation-triangle"></i> <span class="count">10</span></div>
                    <div>Warnings</div>
                </button>
                <button class="button critical-button">
                    <div><i class="fa-solid fa-exclamation-triangle"></i> <span class="count">5</span></div>
                    <div>Critical</div>
                </button>
            </div>
        <div class="donuts">
            <div class="chart1">
            <canvas id="donutChart1" width="400" height="400"></canvas>
            </div>
            <div class="chart2">
            <canvas id="donutChart2" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
    <div class="linear-container">
        <canvas id="myChart" width="800" height="400"></canvas>
        <script src="public/js/linear-chart.js"></script>
    </div>
    <script src="public/js/linear-chart.js"></script>
    <script src="public/js/chart.js"></script>
    <script src="public/js/menu.js"></script>
    <script src="public/js/options.js"></script>
</body>
</html>

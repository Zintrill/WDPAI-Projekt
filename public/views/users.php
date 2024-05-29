<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USERS</title>
    <link rel="stylesheet" type="text/css" href="public/css/background.css">
    <link rel="stylesheet" type="text/css" href="public/css/users.css">
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
            <span class="nav-text"><?php echo isset($username) ? $username : 'name'; ?></span>
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
        <div class="page-title"><h1>Users</h1></div>
    </div>
    <div class="container-users">
        <div class="user-management">
            <button id="addUserButton" class="action-button"><i class="fa-solid fa-user-plus"></i> ADD USER</button>
            <div class="table-header">
                <span class="title-phone">Full Name</span>
                <span class="title">Username</span>
                <span class="title-phone">Password</span>
                <span class="title">Role</span>
                <span class="title">E-mail</span>
            </div>
            <div id="userList"></div> <!-- Lista użytkowników będzie tutaj -->
        </div>
    </div>

    <div class="user-form" id="userForm" style="display: none;">
        <form action="addUser" method="post">
            <input type="text" id="fullName" name="fullName" placeholder="Full Name" required>
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="userPassword" name="userPassword" placeholder="Password" required>
            <select id="userRole" name="userRole" required>
                <option value="" disabled selected>Role</option>
                <option value="administrator">Administrator</option>
                <option value="technician">Technician</option>
                <option value="operator">Operator</option>
            </select>
            <input type="email" id="email" name="email" placeholder="E-mail" required>
            <button type="submit" class="submit-button">Submit</button>
            <button type="button" class="cancel-button" id="cancelUserButton" onclick="cancelUserForm()">Cancel</button>
        </form>
    </div>
    <script src="public/js/menu.js"></script>
    <script src="public/js/options.js"></script>
    <script src="public/js/user-list.js"></script>
    <script src="public/js/user-form.js"></script> <!-- Nowy plik JavaScript -->
</body>
</html>

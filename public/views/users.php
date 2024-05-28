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
            <div id="userList">
                <div class="user-item">
                    <span class="user-info-phone">John Doe</span>
                    <span class="user-info">johndoe</span>
                    <span class="user-info-phone">******** <i class="eye-icon fa-solid fa-eye-low-vision"></i></span>
                    <span class="user-info">Administrator</span>
                    <span class="user-info">example@rcp.com</span>
                    <button class="editButton"><i class="fa-solid fa-pencil"></i></button>
                    <button class="deleteButton"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="user-form" id="userForm" style="display: none;">
        <form>
            <input type="text" id="fullName" name="fullName" placeholder="Full Name">
            <input type="text" id="username" name="username" placeholder="Username">
            <input type="password" id="userPassword" name="userPassword" placeholder="Password">
            <select id="userRole" name="userRole">
                <option value="" disabled selected>Role</option>
                <option value="administrator">Administrator</option>
                <option value="technician">Technician</option>
                <option value="operator">Operator</option>
            </select>
            <input type="email" id="email" name="email" placeholder="E-mail">
            <button type="button" class="submit-button" onclick="submitUserForm()">Submit</button>
            <button type="button" class="cancel-button" id="cancelUserButton" onclick="cancelUserForm()">Cancel</button>
            <button type="button" class="add-another-button" onclick="addAnotherUser()">Add Another User</button>
        </form>
    </div>
    <script src="public/js/menu.js"></script>
    <script src="public/js/options.js"></script>
    <script src="public/js/user-form.js"></script>
</body>
</html>

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
            <span class=" bar"></span>
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
    <div id="userModal" class="add-modal">
        <div class="modal-content">
            <span class="close-button" id="closeUserModal">&times;</span>
            <form id="userForm" action="addUser" method="post" class="user-form">
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="fullName" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <span id="usernameError" class="error-message"></span>
                </div>
                <div class="form-group">
                    <label for="userPassword">Password</label>
                    <input type="password" id="userPassword" name="userPassword" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="userRole">Role</label>
                    <select id="userRole" name="userRole" required>
                        <option value="" disabled selected>Role</option>
                        <option value="1">Administrator</option>
                        <option value="2">Technician</option>
                        <option value="3">Operator</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="E-mail" required>
                    <span id="emailError" class="error-message"></span>
                </div>
                <div class="form-group form-buttons">
                    <button type="submit" class="confirm-button">Submit</button>
                    <button type="button" class="cancel-button" id="cancelUserButton">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="delete-modal">
        <div class="modal-content">
            <span class="close-button" id="closeModal">&times;</span>
            <p>Are you sure you want to delete this user?</p>
            <button id="confirmDeleteButton" class="confirm-button">Yes</button>
            <button id="cancelDeleteButton" class="cancel-button">No</button>
        </div>
    </div>
    <script src="public/js/menu.js"></script>
    <script src="public/js/options.js"></script>
    <script src="public/js/user-list.js"></script>
</body>
</html>

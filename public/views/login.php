<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <title>LOGIN PAGE</title>
</head>
<body>
    <div class="container-login">
        <div class="box">
            <form class="login" action="login" method="POST">
                <img src="public/img/logo.svg" alt="Logo">
                <input name="username" type="text" placeholder="USERNAME" required>
                <input name="password" type="password" placeholder="PASSWORD" required>
                <div class="messages">
                    <?php if (isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    } ?>
                </div>
                <button type="submit" class="button-login">LOGIN</button>
                <p class="register-text">Don’t have account? <a href="#" class="link-register">Create here</a>.</p>
                <button class="register-button">JOIN NOW</button> 
            </form>
        </div>
    </div>
</body>
</html>
